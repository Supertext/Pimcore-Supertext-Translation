import React, { useEffect, useMemo, useState } from 'react'
import { Alert, Button, Checkbox, Modal, Select, Space, Spin, Tag, Text } from '@pimcore/studio-ui-bundle/components'
import { useTranslation } from '@pimcore/studio-ui-bundle/app'
import { useElementHelper, useElementRefresh } from '@pimcore/studio-ui-bundle/modules/element'
import { type ElementInfo, type ElementKind, type LanguageState, type TranslationResult, loadElement, translateElement } from '../api'

interface Props {
  type: ElementKind
  id: number
  onClose: () => void
}

/** "Already translated" for documents = a linked translation exists; for objects = the language has text. */
const exists = (type: ElementKind, l: LanguageState): boolean =>
  type === 'document' ? l.documentId != null : l.hasContent === true

const canTarget = (type: ElementKind, l: LanguageState): boolean =>
  type === 'document' ? (l.allowed === true && l.parentReady === true) : l.editable === true

export const TranslateModal = ({ type, id, onClose }: Props): React.JSX.Element => {
  const { t, i18n } = useTranslation()
  const { openElement } = useElementHelper()
  const { refreshElement } = useElementRefresh(type)
  const [info, setInfo] = useState<ElementInfo | null>(null)
  const [error, setError] = useState<string | null>(null)
  const [source, setSource] = useState<string>('')
  const [targets, setTargets] = useState<string[]>([])
  const [overwrite, setOverwrite] = useState(false)
  const [busy, setBusy] = useState(false)
  const [results, setResults] = useState<TranslationResult[] | null>(null)
  // The editor is reloaded when the dialog closes: reloading it earlier would close the dialog
  // (it lives in the editor's toolbar) before the results are shown.
  const [changed, setChanged] = useState(false)

  const close = (): void => {
    if (changed) {
      refreshElement(id, true)
    }
    onClose()
  }

  const load = async (keepSource?: string): Promise<void> => {
    try {
      const data = await loadElement(type, id)
      setInfo(data)
      const from = keepSource ?? data.source ?? data.languages.find(l => l.hasContent === true)?.language ?? data.languages[0]?.language ?? ''
      setSource(from)
      setTargets(data.languages.filter(l => l.language !== from && !exists(type, l) && canTarget(type, l)).map(l => l.language))
    } catch (e) {
      setError((e as Error).message)
    }
  }

  useEffect(() => { void load() }, [type, id])

  const languages = info?.languages ?? []
  const names = useMemo(() => Object.fromEntries(languages.map(l => [l.language, l.name])), [languages])
  const replacing = targets.some(code => {
    const l = languages.find(x => x.language === code)
    return l !== undefined && exists(type, l)
  })

  const onSourceChange = (value: string): void => {
    setSource(value)
    setTargets(languages.filter(l => l.language !== value && !exists(type, l) && canTarget(type, l)).map(l => l.language))
  }

  const toggle = (code: string, checked: boolean): void => {
    setTargets(checked ? [...targets, code] : targets.filter(x => x !== code))
  }

  const submit = async (): Promise<void> => {
    setBusy(true)
    setError(null)
    setResults(null)
    try {
      const out = await translateElement(type, id, { source: type === 'data-object' ? source : undefined, targets, overwrite })
      setResults(out)
      setOverwrite(false)
      if (type === 'data-object' && out.some(r => r.status === 'translated')) {
        setChanged(true)
      }
      await load(source)
    } catch (e) {
      setError((e as Error).message)
    } finally {
      setBusy(false)
    }
  }

  const date = (ts: number): string => new Date(ts * 1000).toLocaleDateString(i18n.language)

  const marker = (l: LanguageState): React.JSX.Element | null => {
    if (l.lastTranslation != null) {
      return <Tag>{ t('supertext.translated-on', { date: date(l.lastTranslation), interpolation: { escapeValue: false } }) }</Tag>
    }
    if (exists(type, l)) {
      return <Tag>{ t('supertext.already-translated') }</Tag>
    }
    if (type === 'document' && l.parentReady === false) {
      return <Tag color="orange">{ t('supertext.parent-missing') }</Tag>
    }
    if (!canTarget(type, l)) {
      return <Tag color="orange">{ t('supertext.not-allowed') }</Tag>
    }
    return null
  }

  return (
    <Modal
      className="supertext-modal"
      footer={ results !== null
        ? <Button onClick={ close }>{ t('supertext.close') }</Button>
        : (
          <Space>
            <Button onClick={ close }>{ t('supertext.cancel') }</Button>
            <Button
              className="supertext-submit"
              disabled={ busy || info === null || !info.configured || targets.length === 0 || source === '' }
              loading={ busy }
              onClick={ () => { void submit() } }
              type="primary"
            >
              { busy ? t('supertext.translating') : t('supertext.translate') }
            </Button>
          </Space>
          ) }
      onCancel={ close }
      open
      size="ML"
      title={ t('supertext.title') }
    >
      { info === null && error === null && <Spin /> }
      { error !== null && <Alert className="supertext-error" message={ error } showIcon type="error" /> }

      { info !== null && !info.configured && (
        <Alert
          description={ (
            <span>
              { t('supertext.not-configured') }{ ' ' }
              <a href={ info.signupUrl } rel="noopener" target="_blank">{ t('supertext.signup') }</a>{ ' · ' }
              <a href={ info.apiKeyUrl } rel="noopener" target="_blank">{ t('supertext.api-key') }</a>
            </span>
          ) }
          message={ t('supertext.not-configured-title') }
          showIcon
          type="warning"
        />
      ) }

      { results !== null && (
        <Space className="supertext-results" direction="vertical" style={ { width: '100%', marginBottom: 12 } }>
          { results.map(r => (
            <Alert
              action={ r.documentId !== undefined && r.status !== 'error'
                ? <Button onClick={ () => { void openElement({ id: r.documentId!, type: 'document' }) } } size="small">{ t('supertext.open') }</Button>
                : undefined }
              key={ r.language }
              message={ `${names[r.language] ?? r.language}: ${
                r.status === 'translated'
                  ? (r.created === true ? t('supertext.result-created') : t('supertext.result-translated'))
                  : r.status === 'skipped' ? t('supertext.result-skipped') : r.message
              }` }
              showIcon
              type={ r.status === 'translated' ? 'success' : r.status === 'skipped' ? 'info' : 'error' }
            />
          )) }
          <Text type="secondary">{ t('supertext.review-hint') }</Text>
        </Space>
      ) }

      { info !== null && results === null && (
        <Space direction="vertical" size="normal" style={ { width: '100%' } }>
          <div>
            <Text strong>{ t('supertext.from') }</Text>
            <div>
              { type === 'document'
                ? <Text>{ names[source] ?? source } <Text type="secondary">({ source })</Text></Text>
                : (
                  <Select
                    className="supertext-source"
                    onChange={ onSourceChange }
                    options={ languages.filter(l => l.hasContent === true).map(l => ({ value: l.language, label: `${l.name} (${l.language})` })) }
                    style={ { minWidth: 240 } }
                    value={ source }
                  />
                  ) }
            </div>
          </div>
          <div>
            <Text strong>{ t('supertext.into') }</Text>
            <div className="supertext-targets">
              { languages.filter(l => l.language !== source).map(l => (
                <div key={ l.language } style={ { display: 'flex', alignItems: 'center', gap: 8, margin: '6px 0' } }>
                  <Checkbox
                    checked={ targets.includes(l.language) }
                    disabled={ !canTarget(type, l) }
                    onChange={ (e) => { toggle(l.language, e.target.checked) } }
                    value={ l.language }
                  >
                    { l.name } <Text type="secondary">({ l.language })</Text>
                  </Checkbox>
                  { marker(l) }
                </div>
              )) }
            </div>
          </div>
          { replacing && (
            <Alert
              className="supertext-overwrite"
              description={ type === 'document' ? t('supertext.overwrite-help-document') : t('supertext.overwrite-help-object') }
              message={ (
                <Checkbox checked={ overwrite } className="supertext-overwrite-checkbox" onChange={ (e) => { setOverwrite(e.target.checked) } }>
                  { t('supertext.overwrite') }
                </Checkbox>
              ) }
              type="warning"
            />
          ) }
          <Text type="secondary">{ type === 'document' ? t('supertext.hint-document') : t('supertext.hint-object') }</Text>
        </Space>
      ) }
    </Modal>
  )
}
