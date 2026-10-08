import React, { useContext, useState } from 'react'
import { Button } from '@pimcore/studio-ui-bundle/components'
import { useTranslation } from '@pimcore/studio-ui-bundle/app'
import { DocumentContext, useDocumentDraft } from '@pimcore/studio-ui-bundle/modules/document'
import { DataObjectContext, useDataObjectDraft } from '@pimcore/studio-ui-bundle/modules/data-object'
import { TranslateModal } from './translate-modal'
import { type ElementKind } from '../api'

const TranslateButton = ({ type, id }: { type: ElementKind, id: number }): React.JSX.Element => {
  const { t } = useTranslation()
  const [open, setOpen] = useState(false)

  return (
    <>
      <Button
        className="supertext-translate-button"
        onClick={ () => { setOpen(true) } }
      >
        { t('supertext.button') }
      </Button>
      { open && (
        <TranslateModal
          id={ id }
          onClose={ () => { setOpen(false) } }
          type={ type }
        />
      ) }
    </>
  )
}

// Folders, links and hard links have no texts of their own.
const WITHOUT_TEXT = ['folder', 'link', 'hardlink']

export const DocumentTranslateButton = (): React.JSX.Element | null => {
  const { id } = useContext(DocumentContext)
  const { document } = useDocumentDraft(id)
  if (document === undefined || WITHOUT_TEXT.includes(String(document.type))) {
    return null
  }
  return <TranslateButton id={ id } type="document" />
}

export const DataObjectTranslateButton = (): React.JSX.Element | null => {
  const { id } = useContext(DataObjectContext)
  const { dataObject } = useDataObjectDraft(id)
  // Folders have no fields; variants and objects have.
  if (dataObject === undefined || String(dataObject.type) === 'folder') {
    return null
  }
  return <TranslateButton id={ id } type="data-object" />
}
