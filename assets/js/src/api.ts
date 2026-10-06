import { getPrefix } from '@pimcore/studio-ui-bundle/api'

export type ElementKind = 'document' | 'data-object'

export interface LanguageState {
  language: string
  name: string
  // documents
  documentId?: number | null
  path?: string | null
  parentReady?: boolean
  allowed?: boolean
  // data objects
  hasContent?: boolean
  editable?: boolean
  lastTranslation: number | null
}

export interface ElementInfo {
  type: ElementKind
  configured: boolean
  signupUrl: string
  apiKeyUrl: string
  isAdmin: boolean
  source?: string
  fields?: string[]
  languages: LanguageState[]
}

export interface TranslationResult {
  language: string
  status: 'translated' | 'skipped' | 'error'
  message: string
  documentId?: number
  path?: string
  created?: boolean
}

async function call<T> (path: string, init?: RequestInit): Promise<T> {
  const response = await fetch(`${getPrefix()}/supertext${path}`, {
    credentials: 'include',
    headers: { Accept: 'application/json', 'Content-Type': 'application/json' },
    ...init
  })
  const body = await response.json().catch(() => ({}))
  if (!response.ok) {
    throw new Error(typeof body?.error === 'string' ? body.error : (body?.message ?? `HTTP ${response.status}`))
  }
  return body as T
}

export const loadElement = async (type: ElementKind, id: number): Promise<ElementInfo> =>
  await call<ElementInfo>(`/elements/${type}/${id}`)

export const translateElement = async (
  type: ElementKind, id: number, payload: { source?: string, targets: string[], overwrite: boolean }
): Promise<TranslationResult[]> =>
  (await call<{ results: TranslationResult[] }>(`/elements/${type}/${id}/translate`, {
    method: 'POST',
    body: JSON.stringify(payload)
  })).results
