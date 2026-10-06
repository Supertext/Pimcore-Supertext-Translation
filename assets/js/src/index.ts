import { type AbstractModule, type IAbstractPlugin, container } from '@pimcore/studio-ui-bundle'
import { serviceIds } from '@pimcore/studio-ui-bundle/app'
import { componentConfig, type ComponentRegistry } from '@pimcore/studio-ui-bundle/modules/app'
import { DocumentTranslateButton, DataObjectTranslateButton } from './components/toolbar-buttons'

/** Adds "Translate with Supertext" to the document and data object editor toolbars. */
const SupertextToolbarModule: AbstractModule = {
  onInit: (): void => {
    const registry = container.get<ComponentRegistry>(serviceIds['App/ComponentRegistry/ComponentRegistry'])
    registry.registerToSlot(componentConfig.document.editor.toolbar.slots.left.name, {
      name: 'supertextTranslateDocument',
      component: DocumentTranslateButton,
      priority: 900
    })
    registry.registerToSlot(componentConfig.dataObject.editor.toolbar.slots.left.name, {
      name: 'supertextTranslateDataObject',
      component: DataObjectTranslateButton,
      priority: 900
    })
  }
}

export const SupertextPlugin: IAbstractPlugin = {
  name: 'SupertextPlugin',

  onStartup ({ moduleSystem }) {
    moduleSystem.registerModule(SupertextToolbarModule)
  }
}
