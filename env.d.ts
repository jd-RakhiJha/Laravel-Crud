/// <reference types="vite/client" />

interface ImportMeta {
    readonly env: ImportMetaEnv
    glob<T = unknown>(
        globPath: string,
    ): Record<string, () => Promise<T>>
}
