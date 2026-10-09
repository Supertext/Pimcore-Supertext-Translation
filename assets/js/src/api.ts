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

/** A server message: English `message`, plus `key` (supertext.error.<key>), `params` and Supertext's untranslated `detail` for the UI. */
export interface ServerMessage {
  message: string
  key?: string
  params?: Record<string, string | number>
  detail?: string
}

export class ApiError extends Error implements ServerMessage {
  constructor (message: string, readonly key?: string, readonly params?: Record<string, string | number>, readonly detail?: string) {
    super(message)
  }
}

export interface TranslationResult extends ServerMessage {
  language: string
  status: 'translated' | 'skipped' | 'error'
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
    throw new ApiError(
      typeof body?.error === 'string' ? body.error : (body?.message ?? `HTTP ${response.status}`),
      typeof body?.key === 'string' ? body.key : undefined,
      typeof body?.params === 'object' && body.params !== null ? body.params : undefined,
      typeof body?.detail === 'string' ? body.detail : undefined
    )
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
