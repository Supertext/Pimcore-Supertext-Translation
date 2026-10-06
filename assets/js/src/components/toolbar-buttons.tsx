import React, { useContext, useState } from 'react'
import { Button } from '@pimcore/studio-ui-bundle/components'
import { useTranslation } from '@pimcore/studio-ui-bundle/app'
import { DocumentContext } from '@pimcore/studio-ui-bundle/modules/document'
import { DataObjectContext } from '@pimcore/studio-ui-bundle/modules/data-object'
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

export const DocumentTranslateButton = (): React.JSX.Element => {
  const { id } = useContext(DocumentContext)
  return <TranslateButton id={ id } type="document" />
}

export const DataObjectTranslateButton = (): React.JSX.Element => {
  const { id } = useContext(DataObjectContext)
  return <TranslateButton id={ id } type="data-object" />
}
