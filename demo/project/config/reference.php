<?php

// This file is auto-generated and is for apps only. Bundles SHOULD NOT rely on its content.

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Config\Loader\ParamConfigurator as Param;

/**
 * This class provides array-shapes for configuring the services and bundles of an application.
 *
 * Services declared with the config() method below are autowired and autoconfigured by default.
 *
 * This is for apps only. Bundles SHOULD NOT use it.
 *
 * Example:
 *
 *     ```php
 *     // config/services.php
 *     namespace Symfony\Component\DependencyInjection\Loader\Configurator;
 *
 *     return App::config([
 *         'services' => [
 *             'App\\' => [
 *                 'resource' => '../src/',
 *             ],
 *         ],
 *     ]);
 *     ```
 *
 * @psalm-type ImportsConfig = list<string|array{
 *     resource: string,
 *     type?: string|null,
 *     ignore_errors?: bool|'not_found',
 * }>
 * @psalm-type ParametersConfig = array<string, scalar|\UnitEnum|array<scalar|\UnitEnum|array<mixed>|Param|null>|Param|null>
 * @psalm-type ArgumentsType = list<mixed>|array<string, mixed>
 * @psalm-type CallType = array<string, ArgumentsType>|array{0:string, 1?:ArgumentsType, 2?:bool}|array{method:string, arguments?:ArgumentsType, returns_clone?:bool}
 * @psalm-type TagsType = list<string|array<string, array<string, mixed>>> // arrays inside the list must have only one element, with the tag name as the key
 * @psalm-type CallbackType = string|array{0:string|ReferenceConfigurator,1:string}|\Closure|ReferenceConfigurator|ExpressionConfigurator
 * @psalm-type DeprecationType = array{package: string, version: string, message?: string}
 * @psalm-type DefaultsType = array{
 *     public?: bool,
 *     tags?: TagsType,
 *     resource_tags?: TagsType,
 *     autowire?: bool,
 *     autoconfigure?: bool,
 *     bind?: array<string, mixed>,
 * }
 * @psalm-type InstanceofType = array{
 *     shared?: bool,
 *     lazy?: bool|string,
 *     public?: bool,
 *     properties?: array<string, mixed>,
 *     configurator?: CallbackType,
 *     calls?: list<CallType>,
 *     tags?: TagsType,
 *     resource_tags?: TagsType,
 *     autowire?: bool,
 *     bind?: array<string, mixed>,
 *     constructor?: string,
 * }
 * @psalm-type DefinitionType = array{
 *     class?: string,
 *     file?: string,
 *     parent?: string,
 *     shared?: bool,
 *     synthetic?: bool,
 *     lazy?: bool|string,
 *     public?: bool,
 *     abstract?: bool,
 *     deprecated?: DeprecationType,
 *     factory?: CallbackType,
 *     configurator?: CallbackType,
 *     arguments?: ArgumentsType,
 *     properties?: array<string, mixed>,
 *     calls?: list<CallType>,
 *     tags?: TagsType,
 *     resource_tags?: TagsType,
 *     decorates?: string,
 *     decoration_inner_name?: string,
 *     decoration_priority?: int,
 *     decoration_on_invalid?: 'exception'|'ignore'|null,
 *     autowire?: bool,
 *     autoconfigure?: bool,
 *     bind?: array<string, mixed>,
 *     constructor?: string,
 *     from_callable?: CallbackType,
 * }
 * @psalm-type AliasType = string|array{
 *     alias: string,
 *     public?: bool,
 *     deprecated?: DeprecationType,
 * }
 * @psalm-type PrototypeType = array{
 *     resource: string,
 *     namespace?: string,
 *     exclude?: string|list<string>,
 *     parent?: string,
 *     shared?: bool,
 *     lazy?: bool|string,
 *     public?: bool,
 *     abstract?: bool,
 *     deprecated?: DeprecationType,
 *     factory?: CallbackType,
 *     arguments?: ArgumentsType,
 *     properties?: array<string, mixed>,
 *     configurator?: CallbackType,
 *     calls?: list<CallType>,
 *     tags?: TagsType,
 *     resource_tags?: TagsType,
 *     autowire?: bool,
 *     autoconfigure?: bool,
 *     bind?: array<string, mixed>,
 *     constructor?: string,
 * }
 * @psalm-type StackType = array{
 *     stack: list<DefinitionType|AliasType|PrototypeType|array<class-string, ArgumentsType|null>>,
 *     public?: bool,
 *     deprecated?: DeprecationType,
 * }
 * @psalm-type ServicesConfig = array{
 *     _defaults?: DefaultsType,
 *     _instanceof?: array<class-string, InstanceofType>,
 *     ...<string, DefinitionType|AliasType|PrototypeType|StackType|ArgumentsType|null>
 * }
 * @psalm-type ExtensionType = array<string, mixed>
 * @psalm-type PimcoreGenericExecutionEngineConfig = array{
 *     error_handling?: "continue_on_error"|"stop_on_first_error"|Param, // Specifies how errors should be handled for all job run executions. // Default: "continue_on_error"
 *     execution_context?: list<array{ // Default: []
 *         translations_domain?: scalar|Param|null, // Translation domain which should be used by the job run. Default value is "admin". // Default: "admin"
 *         error_handling?: "continue_on_error"|"stop_on_first_error"|Param, // Error handling behavior which should be used by the job run. Overrides the global value.
 *     }>,
 * }
 * @psalm-type PimcoreCustomReportsConfig = array{
 *     definitions?: list<array{ // Default: []
 *         id?: scalar|Param|null,
 *         name?: scalar|Param|null,
 *         niceName?: scalar|Param|null,
 *         sql?: scalar|Param|null,
 *         group?: scalar|Param|null,
 *         groupIconClass?: scalar|Param|null,
 *         iconClass?: scalar|Param|null,
 *         menuShortcut?: bool|Param,
 *         reportClass?: scalar|Param|null,
 *         chartType?: scalar|Param|null,
 *         pieColumn?: scalar|Param|null,
 *         pieLabelColumn?: scalar|Param|null,
 *         xAxis?: mixed,
 *         yAxis?: mixed,
 *         modificationDate?: int|Param,
 *         creationDate?: int|Param,
 *         shareGlobally?: bool|Param,
 *         sharedUserNames?: mixed,
 *         sharedRoleNames?: mixed,
 *         dataSourceConfig?: list<mixed>,
 *         columnConfiguration?: list<mixed>,
 *         pagination?: bool|Param,
 *     }>,
 *     adapters?: array<string, scalar|Param|null>,
 *     enabled_adapters?: array<string, bool|Param>,
 *     config_location?: array{
 *         custom_reports?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled"|Param, // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *         },
 *     },
 * }
 * @psalm-type PimcoreGenericDataIndexConfig = array{
 *     index_service?: array{
 *         client_params?: array{
 *             client_name?: scalar|Param|null, // Name of search client from to be used. // Default: "default"
 *             client_type?: scalar|Param|null, // Type of search client to be used. Allowed values: openSearch, elasticsearch. Supports env vars. // Default: "openSearch"
 *             index_prefix?: scalar|Param|null, // Default: "pimcore_"
 *         },
 *         search_settings?: array{
 *             list_page_size?: scalar|Param|null, // Default: 60
 *             list_max_filter_options?: scalar|Param|null, // Default: 500
 *             search_analyzer_attributes?: array<string, array{ // Default: []
 *                 fields?: mixed, // Default: []
 *             }>,
 *         },
 *         index_settings?: mixed, // Default: []
 *         reindex_settings?: array{
 *             max_polls?: int|Param, // Maximum number of polling attempts when waiting for an async reindex task (default: 720 = 1 hour at 5-second intervals). // Default: 720
 *             poll_interval?: int|Param, // Seconds to wait between reindex task status polls. // Default: 5
 *         },
 *         queue_settings?: array{
 *             worker_count?: scalar|Param|null, // Default: 1
 *             min_batch_size?: scalar|Param|null, // Default: 5
 *             max_batch_size?: scalar|Param|null, // Default: 400
 *         },
 *         calculated_fields_index_mode?: "live"|"query_store"|Param, // Where index values of calculated fields come from: "live" executes the calculator during indexing (default), "query_store" reads the save-time value from the object query table and never executes the calculator while indexing. // Default: "live"
 *         system_fields_settings?: array{
 *             general?: array<string, array{ // Default: []
 *                 type?: scalar|Param|null,
 *                 analyzer?: scalar|Param|null,
 *                 ignore_above?: scalar|Param|null,
 *                 properties?: mixed, // Default: []
 *                 fields?: mixed, // Default: []
 *             }>,
 *             document?: array<string, array{ // Default: []
 *                 type?: scalar|Param|null,
 *                 analyzer?: scalar|Param|null,
 *                 ignore_above?: scalar|Param|null,
 *                 properties?: mixed, // Default: []
 *                 fields?: mixed, // Default: []
 *             }>,
 *             data_object?: array<string, array{ // Default: []
 *                 type?: scalar|Param|null,
 *                 analyzer?: scalar|Param|null,
 *                 ignore_above?: scalar|Param|null,
 *                 properties?: mixed, // Default: []
 *                 fields?: mixed, // Default: []
 *             }>,
 *             asset?: array<string, array{ // Default: []
 *                 type?: scalar|Param|null,
 *                 analyzer?: scalar|Param|null,
 *                 ignore_above?: scalar|Param|null,
 *                 properties?: mixed, // Default: []
 *                 fields?: mixed, // Default: []
 *             }>,
 *         },
 *     },
 *     snapshot?: array{ // Export/import of the whole search index as a portable file bundle (generic-data-index:snapshot:*).
 *         storage?: scalar|Param|null, // Flysystem storage service id the snapshots are written to and read from. // Default: "pimcore.generic_data_index_snapshot.storage"
 *         page_size?: int|Param, // Maximum documents fetched per search_after page during export. // Default: 1000
 *         page_bytes?: int|Param, // Adaptive raw JSON byte target per export page: pages shrink below page_size as documents get larger. Not a hard ceiling, since document size is only known after a page was fetched. // Default: 16777216
 *         bulk_size?: int|Param, // Maximum documents per bulk request during import. // Default: 1000
 *         import_workers?: int|Param, // Worker processes (bin/console subprocesses) that send bulk requests concurrently during import; each keeps one request in flight. More workers use the search engine's write threads in parallel (bounded by its write queue). // Default: 4
 *         bulk_bytes?: int|Param, // Raw JSON byte budget per import bulk request. A request is sent as soon as either bulk_size documents or this many bytes are pending. // Default: 16777216
 *     },
 * }
 * @psalm-type PimcoreStudioBackendConfig = array{
 *     url_prefix?: scalar|Param|null, // Default: "/pimcore-studio/api"
 *     open_api_scan_paths?: list<scalar|Param|null>,
 *     api_token?: array{
 *         lifetime?: int|Param, // Default: 3600
 *     },
 *     allowed_hosts_for_cors?: list<scalar|Param|null>,
 *     security_firewall?: mixed,
 *     asset_default_formats?: array<string, array{ // Default: []
 *         resize_mode?: "resize"|"scaleByWidth"|"scaleByHeight"|Param,
 *         width?: int|Param,
 *         dpi?: int|Param,
 *         format?: "JPEG"|"PNG"|Param,
 *         quality?: int|Param,
 *     }>,
 *     element_recycle_bin_threshold?: int|Param, // Default: 100
 *     mercure_settings?: array{
 *         hub_url_server?: scalar|Param|null, // The url to the mercure hub for the server.This can also be the docker container name (e.g., http://mercure/.well-known/mercure). If it is not set, default will be set to "http(s)://<YOUR_PIMCORE_MAIN_DOMAIN>/hub/.well-known/mercure". // Default: null
 *         hub_url_client?: scalar|Param|null, // The url to the mercure hub for the (frontend) client. If it is not set, the default will be set to "http(s)://<YOUR_CURRENT_PIMCORE_HOST>/hub". It is possible to use "<PIMCORE_SCHEMA_HOST>" as a placeholder for the current schema and host if path to mercure should be different. // Default: null
 *         jwt_key?: scalar|Param|null, // The key used to sign the JWT token. Must be longer than 256 bits. // Default: "some-secret-default"
 *         cookie_lifetime?: int|Param, // Lifetime of the mercure cookie in seconds. Default is one hour. // Default: 3600
 *         jwt_cookie_host?: scalar|Param|null, // Domain where to set the Mercure auth cookie, e.g. ".example.com". // Default: null
 *         jwt_cookie_strictness?: bool|Param, // If true, use SameSite=Strict; if false, use SameSite=None. // Default: true
 *     },
 *     asset_download_settings?: array{
 *         size_limit?: int|Param, // The maximum size of all assets together that can be downloaded in bytes. // Default: 5368709120
 *         amount_limit?: int|Param, // The maximum amount of assets that can be downloaded at once. // Default: 1000
 *     },
 *     csv_settings?: array{
 *         default_delimiter?: scalar|Param|null, // Default delimiter to be used for csv operations. // Default: ";"
 *     },
 *     grid?: array{
 *         asset?: array{
 *             predefined_columns?: list<array{ // Default: []
 *                 group?: scalar|Param|null,
 *                 key?: scalar|Param|null,
 *             }>,
 *         },
 *         data_object?: array{
 *             predefined_columns?: list<array{ // Default: []
 *                 group?: scalar|Param|null,
 *                 key?: scalar|Param|null,
 *             }>,
 *             skip_field_types?: list<scalar|Param|null>,
 *         },
 *     },
 *     search_grid?: array{
 *         asset?: array{
 *             predefined_columns?: list<array{ // Default: []
 *                 group?: scalar|Param|null,
 *                 key?: scalar|Param|null,
 *             }>,
 *         },
 *         data_object?: array{
 *             predefined_columns?: list<array{ // Default: []
 *                 group?: scalar|Param|null,
 *                 key?: scalar|Param|null,
 *             }>,
 *         },
 *     },
 *     notes?: array{
 *         types?: array{ // List all note types for asset, document, and data-object.
 *             asset?: list<scalar|Param|null>,
 *             document?: list<scalar|Param|null>,
 *             data-object?: list<scalar|Param|null>,
 *             ...<string, mixed>
 *         },
 *     },
 *     notifications?: array{
 *         channels?: array<string, array{ // Default: []
 *             enabled?: bool|Param, // Disabling removes the channel from the preferences screen. // Default: true
 *         }>,
 *         email?: array{
 *             template?: scalar|Param|null, // Twig template for notification emails. Receives: title, message, link, name, locale. // Default: "@PimcoreStudioBackend/notification/email.html.twig"
 *         },
 *     },
 *     asset_metadata_adapter_mapping?: array<string, list<scalar|Param|null>>,
 *     data_object_data_adapter_mapping?: array<string, list<scalar|Param|null>>,
 *     document_type_adapter_mapping?: array<string, list<scalar|Param|null>>,
 *     user?: array{
 *         default_key_bindings?: list<array{ // Default: []
 *             key?: scalar|Param|null,
 *             action?: scalar|Param|null,
 *             alt?: scalar|Param|null, // Default: false
 *             ctrl?: scalar|Param|null, // Default: false
 *             shift?: scalar|Param|null, // Default: false
 *         }>,
 *     },
 *     open_api_servers?: list<array{ // Default: []
 *         url?: scalar|Param|null, // The URL to the server.
 *         description?: scalar|Param|null, // A description of the server.
 *     }>,
 *     widget_types?: list<scalar|Param|null>,
 *     studio_perspectives?: array<string, array{ // Default: []
 *         name?: scalar|Param|null,
 *         icon?: null|array{
 *             type?: "name"|"path"|Param,
 *             value?: scalar|Param|null,
 *         },
 *         widgets_left?: array<string, scalar|Param|null>,
 *         widgets_right?: array<string, scalar|Param|null>,
 *         widgets_bottom?: array<string, scalar|Param|null>,
 *         expanded_left?: scalar|Param|null, // The id of the widget that should be expanded on the left side. // Default: null
 *         expanded_right?: scalar|Param|null, // The id of the widget that should be expanded on the right side. // Default: null
 *         context_permissions?: array<string, array<string, scalar|Param|null>>,
 *         ...<string, mixed>
 *     }>,
 *     element_tree_widgets?: array<string, array{ // Default: []
 *         name?: scalar|Param|null,
 *         element_type?: scalar|Param|null, // Default: "object"
 *         page_size?: scalar|Param|null, // Default: null
 *         icon?: null|array{
 *             type?: "name"|"path"|Param,
 *             value?: scalar|Param|null,
 *         },
 *         root_folder?: scalar|Param|null, // Default: "/"
 *         show_root?: bool|Param, // Default: false
 *         classes?: Param|string|list<scalar|Param|null>,
 *         pql?: scalar|Param|null, // Default: null
 *         context_permissions?: list<scalar|Param|null>,
 *         ...<string, mixed>
 *     }>,
 *     studio_from_default_email?: scalar|Param|null, // Default: "studio-admin@pimcore.com"
 *     gdpr_data_extractor?: array{
 *         data_objects?: array{ // Settings for DataObjects DataProvider
 *             classes?: array<string, array{ // Default: []
 *                 allow_delete?: bool|Param, // Allow delete of objects directly in preview grid. // Default: false
 *                 ...<string, mixed>
 *             }>,
 *         },
 *         assets?: array{ // Settings for Assets DataProvider
 *             types?: list<scalar|Param|null>,
 *         },
 *     },
 *     admin_settings?: array{
 *         branding?: array{
 *             background_shade?: scalar|Param|null, // Default: ""
 *             brand_color?: scalar|Param|null, // Default: ""
 *             login_screen_custom_background_image?: array{
 *                 id?: scalar|Param|null,
 *                 type?: scalar|Param|null,
 *             },
 *             custom_logo?: array{
 *                 id?: scalar|Param|null,
 *                 type?: scalar|Param|null,
 *             },
 *         },
 *         assets?: array{
 *             hide_edit_image?: bool|Param, // Default: false
 *             disable_tree_preview?: bool|Param, // Default: false
 *         },
 *     },
 *     mcp?: array{ // MCP (Model Context Protocol) server configuration (experimental)
 *         authentication?: array{
 *             tokens?: array<string, list<scalar|Param|null>>,
 *         },
 *     },
 *     oauth?: array{ // Embedded OAuth 2.1 authorization server (experimental; opt-in). Isolated from the application's global security configuration.
 *         enabled?: bool|Param, // Master switch for the embedded OAuth authorization server. Default off. // Default: false
 *         issuer?: scalar|Param|null, // Issuer identifier (iss) advertised in metadata, returned in the authorization response, stamped on issued tokens and verified by the resource server, e.g. "https://pimcore.example.com". Required once oauth.enabled is true. // Default: null
 *         access_token_ttl?: int|Param, // Access-token lifetime in seconds. // Default: 3600
 *         auth_code_ttl?: int|Param, // Authorization-code lifetime in seconds. // Default: 600
 *         refresh_token_ttl?: int|Param, // Refresh-token lifetime in seconds. // Default: 2592000
 *         consent_path?: scalar|Param|null, // Studio UI route the authorize endpoint redirects to for login/consent. // Default: "/pimcore-studio/oauth/consent"
 *         allow_localhost_loopback_redirect?: bool|Param, // Also accept http://localhost:{port} loopback redirect URIs (any port), alongside the RFC 8252 IP literals 127.0.0.1/[::1]. RFC 8252 marks "localhost" as NOT RECOMMENDED, but some native clients use it; see https://github.com/anthropics/claude-code/issues/42765. Set to false to require IP literals (RFC-strict). // Default: true
 *         cors_allowed_origins?: list<scalar|Param|null>,
 *         client_id_metadata_documents?: array{ // Client ID Metadata Documents (CIMD): accept an HTTPS URL as the client_id and fetch the client metadata from it, instead of pre-registration. No registration endpoint is exposed. Opt-in; default off.
 *             enabled?: bool|Param, // Resolve URL-form client_ids and advertise support in metadata. // Default: false
 *             allowed_hosts?: list<scalar|Param|null>,
 *             allow_insecure?: bool|Param, // Dev only: permit http and private/loopback client_id URLs. Never enable in production. // Default: false
 *             cache_ttl?: int|Param, // Seconds to cache a fetched client metadata document. // Default: 300
 *         },
 *         dynamic_client_registration?: array{ // RFC 7591 Dynamic Client Registration. Exposes an open (unauthenticated) registration endpoint so clients without prior credentials can self-register. Opt-in; default off.
 *             enabled?: bool|Param, // Expose POST /pimcore-oauth/register and advertise it in metadata. // Default: false
 *         },
 *         keys?: array{ // Signing/encryption key material. Reference via env vars; never commit secrets.
 *             private_key?: scalar|Param|null, // Path or contents of the JWT signing private key. // Default: null
 *             public_key?: scalar|Param|null, // Path or contents of the JWT signing public key. // Default: null
 *             passphrase?: scalar|Param|null, // Passphrase for the private key, if any. // Default: null
 *             encryption_key?: scalar|Param|null, // Encryption key for auth codes and refresh tokens. // Default: null
 *         },
 *         clients?: array<string, array{ // Default: []
 *             name?: scalar|Param|null,
 *             redirect_uris?: list<scalar|Param|null>,
 *         }>,
 *         resources?: list<array{ // Default: []
 *             uri?: scalar|Param|null, // Canonical resource URI (audience).
 *             scopes_supported?: list<scalar|Param|null>,
 *             authorization_servers?: list<scalar|Param|null>,
 *         }>,
 *     },
 *     rate_limiting?: array{ // General rate limiting configuration for all Studio API endpoints.
 *         enabled?: bool|Param, // Enable or disable general rate limiting for all Studio API endpoints. // Default: true
 *     },
 *     translations?: array{
 *         path?: scalar|Param|null, // Default: null
 *         auto_create_missing_keys?: bool|Param, // Default: true
 *     },
 *     twig?: array{ // Configure the Twig sandbox policy.
 *         sandbox_security_policy?: array{
 *             tags?: list<scalar|Param|null>,
 *             filters?: list<scalar|Param|null>,
 *             functions?: list<scalar|Param|null>,
 *         },
 *     },
 *     config_location?: array{
 *         element_tree_widgets?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled"|Param, // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *             read_target?: array{
 *                 type?: "symfony-config"|"settings-store"|Param, // Default: null
 *                 options?: list<mixed>,
 *             },
 *         },
 *         studio_perspectives?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled"|Param, // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *             read_target?: array{
 *                 type?: "symfony-config"|"settings-store"|Param, // Default: null
 *                 options?: list<mixed>,
 *             },
 *         },
 *         admin_settings?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled"|Param, // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *             read_target?: array{
 *                 type?: "symfony-config"|"settings-store"|Param, // Default: null
 *                 options?: list<mixed>,
 *             },
 *         },
 *     },
 * }
 * @psalm-type PimcoreStudioUiConfig = array{
 *     url_path?: scalar|Param|null, // Default: "/pimcore-studio"
 *     asset_upload?: array{
 *         max_parallel_uploads?: int|Param, // How many asset uploads a single browser tab sends at the same time. Lower this if bursts of uploads exhaust the PHP-FPM pool. // Default: 5
 *     },
 *     static_resources?: array{
 *         css?: list<scalar|Param|null>,
 *         js?: list<scalar|Param|null>,
 *         editmode?: array{
 *             css?: list<scalar|Param|null>,
 *             js?: list<scalar|Param|null>,
 *         },
 *     },
 *     wysiwyg?: array{
 *         defaultEditorConfig?: array{
 *             document?: mixed, // Default: []
 *             dataObject?: mixed, // Default: []
 *         },
 *     },
 *     csp_header?: bool|array{ // Can be used to enable or disable the Content Security Policy headers.
 *         enabled?: bool|Param, // Default: true
 *         exclude_paths?: list<scalar|Param|null>,
 *         additional_urls?: array{
 *             default-src?: list<scalar|Param|null>,
 *             img-src?: list<scalar|Param|null>,
 *             script-src?: list<scalar|Param|null>,
 *             style-src?: list<scalar|Param|null>,
 *             connect-src?: list<scalar|Param|null>,
 *             font-src?: list<scalar|Param|null>,
 *             media-src?: list<scalar|Param|null>,
 *             frame-src?: list<scalar|Param|null>,
 *         },
 *     },
 *     pagination?: array{
 *         page_size_options?: list<int|Param>,
 *         default_page_size?: int|Param, // Page size a listing starts with. Must be one of page_size_options. // Default: 20
 *         max_page_size?: int|Param, // Upper bound for page sizes users may enter in the page-size changer. Keep it well below the search index result window (index.max_result_window). // Default: 200
 *     },
 * }
 * @psalm-type FrameworkConfig = array{
 *     secret?: scalar|Param|null,
 *     http_method_override?: bool|Param, // Set true to enable support for the '_method' request parameter to determine the intended HTTP method on POST requests. // Default: false
 *     allowed_http_method_override?: null|list<string|Param>,
 *     trust_x_sendfile_type_header?: scalar|Param|null, // Set true to enable support for xsendfile in binary file responses. // Default: "%env(bool:default::SYMFONY_TRUST_X_SENDFILE_TYPE_HEADER)%"
 *     ide?: scalar|Param|null, // Default: "%env(default::SYMFONY_IDE)%"
 *     test?: bool|Param,
 *     default_locale?: scalar|Param|null, // Default: "en"
 *     set_locale_from_accept_language?: bool|Param, // Whether to use the Accept-Language HTTP header to set the Request locale (only when the "_locale" request attribute is not passed). // Default: false
 *     set_content_language_from_locale?: bool|Param, // Whether to set the Content-Language HTTP header on the Response using the Request locale. // Default: false
 *     enabled_locales?: list<scalar|Param|null>,
 *     trusted_hosts?: Param|string|list<scalar|Param|null>,
 *     trusted_proxies?: mixed, // Default: ["%env(default::SYMFONY_TRUSTED_PROXIES)%"]
 *     trusted_headers?: Param|string|list<scalar|Param|null>,
 *     error_controller?: scalar|Param|null, // Default: "error_controller"
 *     handle_all_throwables?: bool|Param, // HttpKernel will handle all kinds of \Throwable. // Default: true
 *     csrf_protection?: bool|array{
 *         enabled?: scalar|Param|null, // Default: null
 *         stateless_token_ids?: list<scalar|Param|null>,
 *         check_header?: scalar|Param|null, // Whether to check the CSRF token in a header in addition to a cookie when using stateless protection. // Default: false
 *         cookie_name?: scalar|Param|null, // The name of the cookie to use when using stateless protection. // Default: "csrf-token"
 *     },
 *     form?: bool|array{ // Form configuration
 *         enabled?: bool|Param, // Default: false
 *         csrf_protection?: bool|array{
 *             enabled?: scalar|Param|null, // Default: null
 *             token_id?: scalar|Param|null, // Default: null
 *             field_name?: scalar|Param|null, // Default: "_token"
 *             field_attr?: array<string, scalar|Param|null>,
 *         },
 *     },
 *     http_cache?: bool|array{ // HTTP cache configuration
 *         enabled?: bool|Param, // Default: false
 *         debug?: bool|Param, // Default: "%kernel.debug%"
 *         trace_level?: "none"|"short"|"full"|Param,
 *         trace_header?: scalar|Param|null,
 *         default_ttl?: int|Param,
 *         private_headers?: list<scalar|Param|null>,
 *         skip_response_headers?: list<scalar|Param|null>,
 *         allow_reload?: bool|Param,
 *         allow_revalidate?: bool|Param,
 *         stale_while_revalidate?: int|Param,
 *         stale_if_error?: int|Param,
 *         terminate_on_cache_hit?: bool|Param,
 *     },
 *     esi?: bool|array{ // ESI configuration
 *         enabled?: bool|Param, // Default: false
 *     },
 *     ssi?: bool|array{ // SSI configuration
 *         enabled?: bool|Param, // Default: false
 *     },
 *     fragments?: bool|array{ // Fragments configuration
 *         enabled?: bool|Param, // Default: false
 *         hinclude_default_template?: scalar|Param|null, // Default: null
 *         path?: scalar|Param|null, // Default: "/_fragment"
 *     },
 *     profiler?: bool|array{ // Profiler configuration
 *         enabled?: bool|Param, // Default: false
 *         collect?: bool|Param, // Default: true
 *         collect_parameter?: scalar|Param|null, // The name of the parameter to use to enable or disable collection on a per request basis. // Default: null
 *         only_exceptions?: bool|Param, // Default: false
 *         only_main_requests?: bool|Param, // Default: false
 *         dsn?: scalar|Param|null, // Default: "file:%kernel.cache_dir%/profiler"
 *         collect_serializer_data?: bool|Param, // Enables the serializer data collector and profiler panel. // Default: false
 *     },
 *     workflows?: bool|array{
 *         enabled?: bool|Param, // Default: false
 *         workflows?: array<string, array{ // Default: []
 *             audit_trail?: bool|array{
 *                 enabled?: bool|Param, // Default: false
 *             },
 *             type?: "workflow"|"state_machine"|Param, // Default: "state_machine"
 *             marking_store?: array{
 *                 type?: "method"|Param,
 *                 property?: scalar|Param|null,
 *                 service?: scalar|Param|null,
 *             },
 *             supports?: Param|string|list<scalar|Param|null>,
 *             definition_validators?: list<scalar|Param|null>,
 *             support_strategy?: scalar|Param|null,
 *             initial_marking?: \BackedEnum|Param|string|list<scalar|Param|null>,
 *             events_to_dispatch?: null|list<string|Param>,
 *             places?: Param|string|list<array{ // Default: []
 *                 name?: scalar|Param|null,
 *                 metadata?: array<string, mixed>,
 *             }>,
 *             transitions?: list<array{ // Default: []
 *                 name?: string|Param,
 *                 guard?: string|Param, // An expression to block the transition.
 *                 from?: \BackedEnum|Param|string|list<array{ // Default: []
 *                     place?: string|Param,
 *                     weight?: int|Param, // Default: 1
 *                 }>,
 *                 to?: \BackedEnum|Param|string|list<array{ // Default: []
 *                     place?: string|Param,
 *                     weight?: int|Param, // Default: 1
 *                 }>,
 *                 weight?: int|Param, // Default: 1
 *                 metadata?: array<string, mixed>,
 *             }>,
 *             metadata?: array<string, mixed>,
 *         }>,
 *     },
 *     router?: bool|array{ // Router configuration
 *         enabled?: bool|Param, // Default: false
 *         resource?: scalar|Param|null,
 *         type?: scalar|Param|null,
 *         cache_dir?: scalar|Param|null, // Deprecated: Setting the "framework.router.cache_dir.cache_dir" configuration option is deprecated. It will be removed in version 8.0. // Default: "%kernel.build_dir%"
 *         default_uri?: scalar|Param|null, // The default URI used to generate URLs in a non-HTTP context. // Default: null
 *         http_port?: scalar|Param|null, // Default: 80
 *         https_port?: scalar|Param|null, // Default: 443
 *         strict_requirements?: scalar|Param|null, // set to true to throw an exception when a parameter does not match the requirements set to false to disable exceptions when a parameter does not match the requirements (and return null instead) set to null to disable parameter checks against requirements 'true' is the preferred configuration in development mode, while 'false' or 'null' might be preferred in production // Default: true
 *         utf8?: bool|Param, // Default: true
 *     },
 *     session?: bool|array{ // Session configuration
 *         enabled?: bool|Param, // Default: false
 *         storage_factory_id?: scalar|Param|null, // Default: "session.storage.factory.native"
 *         handler_id?: scalar|Param|null, // Defaults to using the native session handler, or to the native *file* session handler if "save_path" is not null.
 *         name?: scalar|Param|null,
 *         cookie_lifetime?: scalar|Param|null,
 *         cookie_path?: scalar|Param|null,
 *         cookie_domain?: scalar|Param|null,
 *         cookie_secure?: true|false|"auto"|Param, // Default: "auto"
 *         cookie_httponly?: bool|Param, // Default: true
 *         cookie_samesite?: null|"lax"|"strict"|"none"|Param, // Default: "lax"
 *         use_cookies?: bool|Param,
 *         gc_divisor?: scalar|Param|null,
 *         gc_probability?: scalar|Param|null,
 *         gc_maxlifetime?: scalar|Param|null,
 *         save_path?: scalar|Param|null, // Defaults to "%kernel.cache_dir%/sessions" if the "handler_id" option is not null.
 *         metadata_update_threshold?: int|Param, // Seconds to wait between 2 session metadata updates. // Default: 0
 *         sid_length?: int|Param, // Deprecated: Setting the "framework.session.sid_length.sid_length" configuration option is deprecated. It will be removed in version 8.0. No alternative is provided as PHP 8.4 has deprecated the related option.
 *         sid_bits_per_character?: int|Param, // Deprecated: Setting the "framework.session.sid_bits_per_character.sid_bits_per_character" configuration option is deprecated. It will be removed in version 8.0. No alternative is provided as PHP 8.4 has deprecated the related option.
 *     },
 *     request?: bool|array{ // Request configuration
 *         enabled?: bool|Param, // Default: false
 *         formats?: array<string, Param|string|list<scalar|Param|null>>,
 *     },
 *     assets?: bool|array{ // Assets configuration
 *         enabled?: bool|Param, // Default: true
 *         strict_mode?: bool|Param, // Throw an exception if an entry is missing from the manifest.json. // Default: false
 *         version_strategy?: scalar|Param|null, // Default: null
 *         version?: scalar|Param|null, // Default: null
 *         version_format?: scalar|Param|null, // Default: "%%s?%%s"
 *         json_manifest_path?: scalar|Param|null, // Default: null
 *         base_path?: scalar|Param|null, // Default: ""
 *         base_urls?: Param|string|list<scalar|Param|null>,
 *         packages?: array<string, array{ // Default: []
 *             strict_mode?: bool|Param, // Throw an exception if an entry is missing from the manifest.json. // Default: false
 *             version_strategy?: scalar|Param|null, // Default: null
 *             version?: scalar|Param|null,
 *             version_format?: scalar|Param|null, // Default: null
 *             json_manifest_path?: scalar|Param|null, // Default: null
 *             base_path?: scalar|Param|null, // Default: ""
 *             base_urls?: Param|string|list<scalar|Param|null>,
 *         }>,
 *     },
 *     asset_mapper?: bool|array{ // Asset Mapper configuration
 *         enabled?: bool|Param, // Default: false
 *         paths?: Param|string|array<string, scalar|Param|null>,
 *         excluded_patterns?: list<scalar|Param|null>,
 *         exclude_dotfiles?: bool|Param, // If true, any files starting with "." will be excluded from the asset mapper. // Default: true
 *         server?: bool|Param, // If true, a "dev server" will return the assets from the public directory (true in "debug" mode only by default). // Default: true
 *         public_prefix?: scalar|Param|null, // The public path where the assets will be written to (and served from when "server" is true). // Default: "/assets/"
 *         missing_import_mode?: "strict"|"warn"|"ignore"|Param, // Behavior if an asset cannot be found when imported from JavaScript or CSS files - e.g. "import './non-existent.js'". "strict" means an exception is thrown, "warn" means a warning is logged, "ignore" means the import is left as-is. // Default: "warn"
 *         extensions?: array<string, scalar|Param|null>,
 *         importmap_path?: scalar|Param|null, // The path of the importmap.php file. // Default: "%kernel.project_dir%/importmap.php"
 *         importmap_polyfill?: scalar|Param|null, // The importmap name that will be used to load the polyfill. Set to false to disable. // Default: "es-module-shims"
 *         importmap_script_attributes?: array<string, scalar|Param|null>,
 *         vendor_dir?: scalar|Param|null, // The directory to store JavaScript vendors. // Default: "%kernel.project_dir%/assets/vendor"
 *         precompress?: bool|array{ // Precompress assets with Brotli, Zstandard and gzip.
 *             enabled?: bool|Param, // Default: false
 *             formats?: list<scalar|Param|null>,
 *             extensions?: list<scalar|Param|null>,
 *         },
 *     },
 *     translator?: bool|array{ // Translator configuration
 *         enabled?: bool|Param, // Default: true
 *         fallbacks?: Param|string|list<scalar|Param|null>,
 *         logging?: bool|Param, // Default: false
 *         formatter?: scalar|Param|null, // Default: "translator.formatter.default"
 *         cache_dir?: scalar|Param|null, // Default: "%kernel.cache_dir%/translations"
 *         default_path?: scalar|Param|null, // The default path used to load translations. // Default: "%kernel.project_dir%/translations"
 *         paths?: list<scalar|Param|null>,
 *         pseudo_localization?: bool|array{
 *             enabled?: bool|Param, // Default: false
 *             accents?: bool|Param, // Default: true
 *             expansion_factor?: float|Param, // Default: 1.0
 *             brackets?: bool|Param, // Default: true
 *             parse_html?: bool|Param, // Default: false
 *             localizable_html_attributes?: list<scalar|Param|null>,
 *         },
 *         providers?: array<string, array{ // Default: []
 *             dsn?: scalar|Param|null,
 *             domains?: list<scalar|Param|null>,
 *             locales?: list<scalar|Param|null>,
 *         }>,
 *         globals?: array<string, Param|string|array{ // Default: []
 *             value?: mixed,
 *             message?: string|Param,
 *             parameters?: array<string, scalar|Param|null>,
 *             domain?: string|Param,
 *         }>,
 *     },
 *     validation?: bool|array{ // Validation configuration
 *         enabled?: bool|Param, // Default: true
 *         cache?: scalar|Param|null, // Deprecated: Setting the "framework.validation.cache.cache" configuration option is deprecated. It will be removed in version 8.0.
 *         enable_attributes?: bool|Param, // Default: true
 *         static_method?: Param|string|list<scalar|Param|null>,
 *         translation_domain?: scalar|Param|null, // Default: "validators"
 *         email_validation_mode?: "html5"|"html5-allow-no-tld"|"strict"|"loose"|Param, // Default: "html5"
 *         mapping?: array{
 *             paths?: list<scalar|Param|null>,
 *         },
 *         not_compromised_password?: bool|array{
 *             enabled?: bool|Param, // When disabled, compromised passwords will be accepted as valid. // Default: true
 *             endpoint?: scalar|Param|null, // API endpoint for the NotCompromisedPassword Validator. // Default: null
 *         },
 *         disable_translation?: bool|Param, // Default: false
 *         auto_mapping?: array<string, array{ // Default: []
 *             services?: list<scalar|Param|null>,
 *         }>,
 *     },
 *     annotations?: bool|array{
 *         enabled?: bool|Param, // Default: false
 *     },
 *     serializer?: bool|array{ // Serializer configuration
 *         enabled?: bool|Param, // Default: true
 *         enable_attributes?: bool|Param, // Default: true
 *         name_converter?: scalar|Param|null,
 *         circular_reference_handler?: scalar|Param|null,
 *         max_depth_handler?: scalar|Param|null,
 *         mapping?: array{
 *             paths?: list<scalar|Param|null>,
 *         },
 *         default_context?: array<string, mixed>,
 *         named_serializers?: array<string, array{ // Default: []
 *             name_converter?: scalar|Param|null,
 *             default_context?: array<string, mixed>,
 *             include_built_in_normalizers?: bool|Param, // Whether to include the built-in normalizers // Default: true
 *             include_built_in_encoders?: bool|Param, // Whether to include the built-in encoders // Default: true
 *         }>,
 *     },
 *     property_access?: bool|array{ // Property access configuration
 *         enabled?: bool|Param, // Default: true
 *         magic_call?: bool|Param, // Default: false
 *         magic_get?: bool|Param, // Default: true
 *         magic_set?: bool|Param, // Default: true
 *         throw_exception_on_invalid_index?: bool|Param, // Default: false
 *         throw_exception_on_invalid_property_path?: bool|Param, // Default: true
 *     },
 *     type_info?: bool|array{ // Type info configuration
 *         enabled?: bool|Param, // Default: true
 *         aliases?: array<string, scalar|Param|null>,
 *     },
 *     property_info?: bool|array{ // Property info configuration
 *         enabled?: bool|Param, // Default: true
 *         with_constructor_extractor?: bool|Param, // Registers the constructor extractor.
 *     },
 *     cache?: array{ // Cache configuration
 *         prefix_seed?: scalar|Param|null, // Used to namespace cache keys when using several apps with the same shared backend. // Default: "_%kernel.project_dir%.%kernel.container_class%"
 *         app?: scalar|Param|null, // App related cache pools configuration. // Default: "cache.adapter.filesystem"
 *         system?: scalar|Param|null, // System related cache pools configuration. // Default: "cache.adapter.system"
 *         directory?: scalar|Param|null, // Default: "%kernel.share_dir%/pools/app"
 *         default_psr6_provider?: scalar|Param|null,
 *         default_redis_provider?: scalar|Param|null, // Default: "redis://localhost"
 *         default_valkey_provider?: scalar|Param|null, // Default: "valkey://localhost"
 *         default_memcached_provider?: scalar|Param|null, // Default: "memcached://localhost"
 *         default_doctrine_dbal_provider?: scalar|Param|null, // Default: "database_connection"
 *         default_pdo_provider?: scalar|Param|null, // Default: null
 *         pools?: array<string, array{ // Default: []
 *             adapters?: Param|string|list<scalar|Param|null>,
 *             tags?: scalar|Param|null, // Default: null
 *             public?: bool|Param, // Default: false
 *             default_lifetime?: scalar|Param|null, // Default lifetime of the pool.
 *             provider?: scalar|Param|null, // Overwrite the setting from the default provider for this adapter.
 *             early_expiration_message_bus?: scalar|Param|null,
 *             clearer?: scalar|Param|null,
 *         }>,
 *     },
 *     php_errors?: array{ // PHP errors handling configuration
 *         log?: mixed, // Use the application logger instead of the PHP logger for logging PHP errors. // Default: true
 *         throw?: bool|Param, // Throw PHP errors as \ErrorException instances. // Default: true
 *     },
 *     exceptions?: array<string, array{ // Default: []
 *         log_level?: scalar|Param|null, // The level of log message. Null to let Symfony decide. // Default: null
 *         status_code?: scalar|Param|null, // The status code of the response. Null or 0 to let Symfony decide. // Default: null
 *         log_channel?: scalar|Param|null, // The channel of log message. Null to let Symfony decide. // Default: null
 *     }>,
 *     web_link?: bool|array{ // Web links configuration
 *         enabled?: bool|Param, // Default: true
 *     },
 *     lock?: Param|bool|string|array{ // Lock configuration
 *         enabled?: bool|Param, // Default: true
 *         resources?: Param|string|array<string, Param|string|list<scalar|Param|null>>,
 *     },
 *     semaphore?: Param|bool|string|array{ // Semaphore configuration
 *         enabled?: bool|Param, // Default: false
 *         resources?: Param|string|array<string, scalar|Param|null>,
 *     },
 *     messenger?: bool|array{ // Messenger configuration
 *         enabled?: bool|Param, // Default: true
 *         routing?: array<string, Param|string|array{ // Default: []
 *             senders?: list<scalar|Param|null>,
 *         }>,
 *         serializer?: array{
 *             default_serializer?: scalar|Param|null, // Service id to use as the default serializer for the transports. // Default: "messenger.transport.native_php_serializer"
 *             symfony_serializer?: array{
 *                 format?: scalar|Param|null, // Serialization format for the messenger.transport.symfony_serializer service (which is not the serializer used by default). // Default: "json"
 *                 context?: array<string, mixed>,
 *             },
 *         },
 *         transports?: array<string, Param|string|array{ // Default: []
 *             dsn?: scalar|Param|null,
 *             serializer?: scalar|Param|null, // Service id of a custom serializer to use. // Default: null
 *             options?: array<string, mixed>,
 *             failure_transport?: scalar|Param|null, // Transport name to send failed messages to (after all retries have failed). // Default: null
 *             retry_strategy?: Param|string|array{
 *                 service?: scalar|Param|null, // Service id to override the retry strategy entirely. // Default: null
 *                 max_retries?: int|Param, // Default: 3
 *                 delay?: int|Param, // Time in ms to delay (or the initial value when multiplier is used). // Default: 1000
 *                 multiplier?: float|Param, // If greater than 1, delay will grow exponentially for each retry: this delay = (delay * (multiple ^ retries)). // Default: 2
 *                 max_delay?: int|Param, // Max time in ms that a retry should ever be delayed (0 = infinite). // Default: 0
 *                 jitter?: float|Param, // Randomness to apply to the delay (between 0 and 1). // Default: 0.1
 *             },
 *             rate_limiter?: scalar|Param|null, // Rate limiter name to use when processing messages. // Default: null
 *         }>,
 *         failure_transport?: scalar|Param|null, // Transport name to send failed messages to (after all retries have failed). // Default: null
 *         stop_worker_on_signals?: Param|int|string|list<scalar|Param|null>,
 *         default_bus?: scalar|Param|null, // Default: null
 *         buses?: array<string, array{ // Default: {"messenger.bus.default":{"default_middleware":{"enabled":true,"allow_no_handlers":false,"allow_no_senders":true},"middleware":[]}}
 *             default_middleware?: Param|bool|string|array{
 *                 enabled?: bool|Param, // Default: true
 *                 allow_no_handlers?: bool|Param, // Default: false
 *                 allow_no_senders?: bool|Param, // Default: true
 *             },
 *             middleware?: Param|string|list<Param|string|array{ // Default: []
 *                 id?: scalar|Param|null,
 *                 arguments?: list<mixed>,
 *             }>,
 *         }>,
 *     },
 *     scheduler?: bool|array{ // Scheduler configuration
 *         enabled?: bool|Param, // Default: true
 *     },
 *     disallow_search_engine_index?: bool|Param, // Enabled by default when debug is enabled. // Default: true
 *     http_client?: bool|array{ // HTTP Client configuration
 *         enabled?: bool|Param, // Default: true
 *         max_host_connections?: int|Param, // The maximum number of connections to a single host.
 *         default_options?: array{
 *             headers?: array<string, mixed>,
 *             vars?: array<string, mixed>,
 *             max_redirects?: int|Param, // The maximum number of redirects to follow.
 *             http_version?: scalar|Param|null, // The default HTTP version, typically 1.1 or 2.0, leave to null for the best version.
 *             resolve?: array<string, scalar|Param|null>,
 *             proxy?: scalar|Param|null, // The URL of the proxy to pass requests through or null for automatic detection.
 *             no_proxy?: scalar|Param|null, // A comma separated list of hosts that do not require a proxy to be reached.
 *             timeout?: float|Param, // The idle timeout, defaults to the "default_socket_timeout" ini parameter.
 *             max_duration?: float|Param, // The maximum execution time for the request+response as a whole.
 *             bindto?: scalar|Param|null, // A network interface name, IP address, a host name or a UNIX socket to bind to.
 *             verify_peer?: bool|Param, // Indicates if the peer should be verified in a TLS context.
 *             verify_host?: bool|Param, // Indicates if the host should exist as a certificate common name.
 *             cafile?: scalar|Param|null, // A certificate authority file.
 *             capath?: scalar|Param|null, // A directory that contains multiple certificate authority files.
 *             local_cert?: scalar|Param|null, // A PEM formatted certificate file.
 *             local_pk?: scalar|Param|null, // A private key file.
 *             passphrase?: scalar|Param|null, // The passphrase used to encrypt the "local_pk" file.
 *             ciphers?: scalar|Param|null, // A list of TLS ciphers separated by colons, commas or spaces (e.g. "RC3-SHA:TLS13-AES-128-GCM-SHA256"...)
 *             peer_fingerprint?: array{ // Associative array: hashing algorithm => hash(es).
 *                 sha1?: mixed,
 *                 pin-sha256?: mixed,
 *                 md5?: mixed,
 *             },
 *             crypto_method?: scalar|Param|null, // The minimum version of TLS to accept; must be one of STREAM_CRYPTO_METHOD_TLSv*_CLIENT constants.
 *             extra?: array<string, mixed>,
 *             rate_limiter?: scalar|Param|null, // Rate limiter name to use for throttling requests. // Default: null
 *             caching?: bool|array{ // Caching configuration.
 *                 enabled?: bool|Param, // Default: false
 *                 cache_pool?: string|Param, // The taggable cache pool to use for storing the responses. // Default: "cache.http_client"
 *                 shared?: bool|Param, // Indicates whether the cache is shared (public) or private. // Default: true
 *                 max_ttl?: int|Param, // The maximum TTL (in seconds) allowed for cached responses. Null means no cap. // Default: null
 *             },
 *             retry_failed?: bool|array{
 *                 enabled?: bool|Param, // Default: false
 *                 retry_strategy?: scalar|Param|null, // service id to override the retry strategy. // Default: null
 *                 http_codes?: Param|int|string|array<string, array{ // Default: []
 *                     code?: int|Param,
 *                     methods?: Param|string|list<string|Param>,
 *                 }>,
 *                 max_retries?: int|Param, // Default: 3
 *                 delay?: int|Param, // Time in ms to delay (or the initial value when multiplier is used). // Default: 1000
 *                 multiplier?: float|Param, // If greater than 1, delay will grow exponentially for each retry: delay * (multiple ^ retries). // Default: 2
 *                 max_delay?: int|Param, // Max time in ms that a retry should ever be delayed (0 = infinite). // Default: 0
 *                 jitter?: float|Param, // Randomness in percent (between 0 and 1) to apply to the delay. // Default: 0.1
 *             },
 *         },
 *         mock_response_factory?: scalar|Param|null, // The id of the service that should generate mock responses. It should be either an invokable or an iterable.
 *         scoped_clients?: array<string, Param|string|array{ // Default: []
 *             scope?: scalar|Param|null, // The regular expression that the request URL must match before adding the other options. When none is provided, the base URI is used instead.
 *             base_uri?: scalar|Param|null, // The URI to resolve relative URLs, following rules in RFC 3985, section 2.
 *             auth_basic?: scalar|Param|null, // An HTTP Basic authentication "username:password".
 *             auth_bearer?: scalar|Param|null, // A token enabling HTTP Bearer authorization.
 *             auth_ntlm?: scalar|Param|null, // A "username:password" pair to use Microsoft NTLM authentication (requires the cURL extension).
 *             query?: array<string, scalar|Param|null>,
 *             headers?: array<string, mixed>,
 *             max_redirects?: int|Param, // The maximum number of redirects to follow.
 *             http_version?: scalar|Param|null, // The default HTTP version, typically 1.1 or 2.0, leave to null for the best version.
 *             resolve?: array<string, scalar|Param|null>,
 *             proxy?: scalar|Param|null, // The URL of the proxy to pass requests through or null for automatic detection.
 *             no_proxy?: scalar|Param|null, // A comma separated list of hosts that do not require a proxy to be reached.
 *             timeout?: float|Param, // The idle timeout, defaults to the "default_socket_timeout" ini parameter.
 *             max_duration?: float|Param, // The maximum execution time for the request+response as a whole.
 *             bindto?: scalar|Param|null, // A network interface name, IP address, a host name or a UNIX socket to bind to.
 *             verify_peer?: bool|Param, // Indicates if the peer should be verified in a TLS context.
 *             verify_host?: bool|Param, // Indicates if the host should exist as a certificate common name.
 *             cafile?: scalar|Param|null, // A certificate authority file.
 *             capath?: scalar|Param|null, // A directory that contains multiple certificate authority files.
 *             local_cert?: scalar|Param|null, // A PEM formatted certificate file.
 *             local_pk?: scalar|Param|null, // A private key file.
 *             passphrase?: scalar|Param|null, // The passphrase used to encrypt the "local_pk" file.
 *             ciphers?: scalar|Param|null, // A list of TLS ciphers separated by colons, commas or spaces (e.g. "RC3-SHA:TLS13-AES-128-GCM-SHA256"...).
 *             peer_fingerprint?: array{ // Associative array: hashing algorithm => hash(es).
 *                 sha1?: mixed,
 *                 pin-sha256?: mixed,
 *                 md5?: mixed,
 *             },
 *             crypto_method?: scalar|Param|null, // The minimum version of TLS to accept; must be one of STREAM_CRYPTO_METHOD_TLSv*_CLIENT constants.
 *             extra?: array<string, mixed>,
 *             rate_limiter?: scalar|Param|null, // Rate limiter name to use for throttling requests. // Default: null
 *             caching?: bool|array{ // Caching configuration.
 *                 enabled?: bool|Param, // Default: false
 *                 cache_pool?: string|Param, // The taggable cache pool to use for storing the responses. // Default: "cache.http_client"
 *                 shared?: bool|Param, // Indicates whether the cache is shared (public) or private. // Default: true
 *                 max_ttl?: int|Param, // The maximum TTL (in seconds) allowed for cached responses. Null means no cap. // Default: null
 *             },
 *             retry_failed?: bool|array{
 *                 enabled?: bool|Param, // Default: false
 *                 retry_strategy?: scalar|Param|null, // service id to override the retry strategy. // Default: null
 *                 http_codes?: Param|int|string|array<string, array{ // Default: []
 *                     code?: int|Param,
 *                     methods?: Param|string|list<string|Param>,
 *                 }>,
 *                 max_retries?: int|Param, // Default: 3
 *                 delay?: int|Param, // Time in ms to delay (or the initial value when multiplier is used). // Default: 1000
 *                 multiplier?: float|Param, // If greater than 1, delay will grow exponentially for each retry: delay * (multiple ^ retries). // Default: 2
 *                 max_delay?: int|Param, // Max time in ms that a retry should ever be delayed (0 = infinite). // Default: 0
 *                 jitter?: float|Param, // Randomness in percent (between 0 and 1) to apply to the delay. // Default: 0.1
 *             },
 *         }>,
 *     },
 *     mailer?: bool|array{ // Mailer configuration
 *         enabled?: bool|Param, // Default: true
 *         message_bus?: scalar|Param|null, // The message bus to use. Defaults to the default bus if the Messenger component is installed. // Default: null
 *         dsn?: scalar|Param|null, // Default: null
 *         transports?: array<string, scalar|Param|null>,
 *         envelope?: array{ // Mailer Envelope configuration
 *             sender?: scalar|Param|null,
 *             recipients?: Param|string|list<scalar|Param|null>,
 *             allowed_recipients?: Param|string|list<scalar|Param|null>,
 *         },
 *         headers?: array<string, Param|string|array{ // Default: []
 *             value?: mixed,
 *         }>,
 *         dkim_signer?: bool|array{ // DKIM signer configuration
 *             enabled?: bool|Param, // Default: false
 *             key?: scalar|Param|null, // Key content, or path to key (in PEM format with the `file://` prefix) // Default: ""
 *             domain?: scalar|Param|null, // Default: ""
 *             select?: scalar|Param|null, // Default: ""
 *             passphrase?: scalar|Param|null, // The private key passphrase // Default: ""
 *             options?: array<string, mixed>,
 *         },
 *         smime_signer?: bool|array{ // S/MIME signer configuration
 *             enabled?: bool|Param, // Default: false
 *             key?: scalar|Param|null, // Path to key (in PEM format) // Default: ""
 *             certificate?: scalar|Param|null, // Path to certificate (in PEM format without the `file://` prefix) // Default: ""
 *             passphrase?: scalar|Param|null, // The private key passphrase // Default: null
 *             extra_certificates?: scalar|Param|null, // Default: null
 *             sign_options?: int|Param, // Default: null
 *         },
 *         smime_encrypter?: bool|array{ // S/MIME encrypter configuration
 *             enabled?: bool|Param, // Default: false
 *             repository?: scalar|Param|null, // S/MIME certificate repository service. This service shall implement the `Symfony\Component\Mailer\EventListener\SmimeCertificateRepositoryInterface`. // Default: ""
 *             cipher?: int|Param, // A set of algorithms used to encrypt the message // Default: null
 *         },
 *     },
 *     secrets?: bool|array{
 *         enabled?: bool|Param, // Default: true
 *         vault_directory?: scalar|Param|null, // Default: "%kernel.project_dir%/config/secrets/%kernel.runtime_environment%"
 *         local_dotenv_file?: scalar|Param|null, // Default: "%kernel.project_dir%/.env.%kernel.environment%.local"
 *         decryption_env_var?: scalar|Param|null, // Default: "base64:default::SYMFONY_DECRYPTION_SECRET"
 *     },
 *     notifier?: bool|array{ // Notifier configuration
 *         enabled?: bool|Param, // Default: false
 *         message_bus?: scalar|Param|null, // The message bus to use. Defaults to the default bus if the Messenger component is installed. // Default: null
 *         chatter_transports?: array<string, scalar|Param|null>,
 *         texter_transports?: array<string, scalar|Param|null>,
 *         notification_on_failed_messages?: bool|Param, // Default: false
 *         channel_policy?: array<string, Param|string|list<scalar|Param|null>>,
 *         admin_recipients?: list<array{ // Default: []
 *             email?: scalar|Param|null,
 *             phone?: scalar|Param|null, // Default: ""
 *         }>,
 *     },
 *     rate_limiter?: bool|array{ // Rate limiter configuration
 *         enabled?: bool|Param, // Default: true
 *         limiters?: array<string, array{ // Default: []
 *             lock_factory?: scalar|Param|null, // The service ID of the lock factory used by this limiter (or null to disable locking). // Default: "auto"
 *             cache_pool?: scalar|Param|null, // The cache pool to use for storing the current limiter state. // Default: "cache.rate_limiter"
 *             storage_service?: scalar|Param|null, // The service ID of a custom storage implementation, this precedes any configured "cache_pool". // Default: null
 *             policy?: "fixed_window"|"token_bucket"|"sliding_window"|"compound"|"no_limit"|Param, // The algorithm to be used by this limiter.
 *             limiters?: Param|string|list<scalar|Param|null>,
 *             limit?: int|Param, // The maximum allowed hits in a fixed interval or burst.
 *             interval?: scalar|Param|null, // Configures the fixed interval if "policy" is set to "fixed_window" or "sliding_window". The value must be a number followed by "second", "minute", "hour", "day", "week" or "month" (or their plural equivalent).
 *             rate?: array{ // Configures the fill rate if "policy" is set to "token_bucket".
 *                 interval?: scalar|Param|null, // Configures the rate interval. The value must be a number followed by "second", "minute", "hour", "day", "week" or "month" (or their plural equivalent).
 *                 amount?: int|Param, // Amount of tokens to add each interval. // Default: 1
 *             },
 *         }>,
 *     },
 *     uid?: bool|array{ // Uid configuration
 *         enabled?: bool|Param, // Default: true
 *         default_uuid_version?: 7|6|4|1|Param, // Default: 7
 *         name_based_uuid_version?: 5|3|Param, // Default: 5
 *         name_based_uuid_namespace?: scalar|Param|null,
 *         time_based_uuid_version?: 7|6|1|Param, // Default: 7
 *         time_based_uuid_node?: scalar|Param|null,
 *     },
 *     html_sanitizer?: bool|array{ // HtmlSanitizer configuration
 *         enabled?: bool|Param, // Default: true
 *         sanitizers?: array<string, array{ // Default: []
 *             allow_safe_elements?: bool|Param, // Allows "safe" elements and attributes. // Default: false
 *             allow_static_elements?: bool|Param, // Allows all static elements and attributes from the W3C Sanitizer API standard. // Default: false
 *             allow_elements?: array<string, mixed>,
 *             block_elements?: Param|string|list<string|Param>,
 *             drop_elements?: Param|string|list<string|Param>,
 *             allow_attributes?: array<string, mixed>,
 *             drop_attributes?: array<string, mixed>,
 *             force_attributes?: array<string, array<string, string|Param>>,
 *             force_https_urls?: bool|Param, // Transforms URLs using the HTTP scheme to use the HTTPS scheme instead. // Default: false
 *             allowed_link_schemes?: Param|string|list<string|Param>,
 *             allowed_link_hosts?: Param|null|string|list<string|Param>,
 *             allow_relative_links?: bool|Param, // Allows relative URLs to be used in links href attributes. // Default: false
 *             allowed_media_schemes?: Param|string|list<string|Param>,
 *             allowed_media_hosts?: Param|null|string|list<string|Param>,
 *             allow_relative_medias?: bool|Param, // Allows relative URLs to be used in media source attributes (img, audio, video, ...). // Default: false
 *             with_attribute_sanitizers?: Param|string|list<string|Param>,
 *             without_attribute_sanitizers?: Param|string|list<string|Param>,
 *             max_input_length?: int|Param, // The maximum length allowed for the sanitized input. // Default: 0
 *         }>,
 *     },
 *     webhook?: bool|array{ // Webhook configuration
 *         enabled?: bool|Param, // Default: false
 *         message_bus?: scalar|Param|null, // The message bus to use. // Default: "messenger.default_bus"
 *         routing?: array<string, array{ // Default: []
 *             service?: scalar|Param|null,
 *             secret?: scalar|Param|null, // The secret used to verify incoming request signatures. It must be set in production: with an empty value, depending on the parser, requests from any sender are accepted or every request is rejected. // Default: ""
 *         }>,
 *     },
 *     remote_event?: bool|array{ // RemoteEvent configuration
 *         enabled?: bool|Param, // Default: false
 *     },
 *     json_streamer?: bool|array{ // JSON streamer configuration
 *         enabled?: bool|Param, // Default: false
 *     },
 * }
 * @psalm-type MonologConfig = array{
 *     use_microseconds?: scalar|Param|null, // Default: true
 *     channels?: list<scalar|Param|null>,
 *     handlers?: array<string, array{ // Default: []
 *         type?: scalar|Param|null,
 *         id?: scalar|Param|null,
 *         enabled?: bool|Param, // Default: true
 *         priority?: scalar|Param|null, // Default: 0
 *         level?: scalar|Param|null, // Default: "DEBUG"
 *         bubble?: bool|Param, // Default: true
 *         interactive_only?: bool|Param, // Default: false
 *         app_name?: scalar|Param|null, // Default: null
 *         fill_extra_context?: bool|Param, // Default: false
 *         include_stacktraces?: bool|Param, // Default: false
 *         process_psr_3_messages?: array{
 *             enabled?: bool|Param|null, // Default: null
 *             date_format?: scalar|Param|null,
 *             remove_used_context_fields?: bool|Param,
 *             ...<string, mixed>
 *         },
 *         path?: scalar|Param|null, // Default: "%kernel.logs_dir%/%kernel.environment%.log"
 *         file_permission?: scalar|Param|null, // Default: null
 *         use_locking?: bool|Param, // Default: false
 *         filename_format?: scalar|Param|null, // Default: "{filename}-{date}"
 *         date_format?: scalar|Param|null, // Default: "Y-m-d"
 *         ident?: scalar|Param|null, // Default: false
 *         logopts?: scalar|Param|null, // Default: 1
 *         facility?: scalar|Param|null, // Default: "user"
 *         max_files?: scalar|Param|null, // Default: 0
 *         action_level?: scalar|Param|null, // Default: "WARNING"
 *         activation_strategy?: scalar|Param|null, // Default: null
 *         stop_buffering?: bool|Param, // Default: true
 *         passthru_level?: scalar|Param|null, // Default: null
 *         excluded_404s?: list<scalar|Param|null>,
 *         excluded_http_codes?: list<array{ // Default: []
 *             code?: scalar|Param|null,
 *             urls?: list<scalar|Param|null>,
 *         }>,
 *         accepted_levels?: list<scalar|Param|null>,
 *         min_level?: scalar|Param|null, // Default: "DEBUG"
 *         max_level?: scalar|Param|null, // Default: "EMERGENCY"
 *         buffer_size?: scalar|Param|null, // Default: 0
 *         flush_on_overflow?: bool|Param, // Default: false
 *         handler?: scalar|Param|null,
 *         url?: scalar|Param|null,
 *         exchange?: scalar|Param|null,
 *         exchange_name?: scalar|Param|null, // Default: "log"
 *         room?: scalar|Param|null,
 *         message_format?: scalar|Param|null, // Default: "text"
 *         api_version?: scalar|Param|null, // Default: null
 *         channel?: scalar|Param|null, // Default: null
 *         bot_name?: scalar|Param|null, // Default: "Monolog"
 *         use_attachment?: scalar|Param|null, // Default: true
 *         use_short_attachment?: scalar|Param|null, // Default: false
 *         include_extra?: scalar|Param|null, // Default: false
 *         icon_emoji?: scalar|Param|null, // Default: null
 *         webhook_url?: scalar|Param|null,
 *         exclude_fields?: list<scalar|Param|null>,
 *         team?: scalar|Param|null,
 *         notify?: scalar|Param|null, // Default: false
 *         nickname?: scalar|Param|null, // Default: "Monolog"
 *         token?: scalar|Param|null,
 *         region?: scalar|Param|null,
 *         source?: scalar|Param|null,
 *         use_ssl?: bool|Param, // Default: true
 *         user?: mixed,
 *         title?: scalar|Param|null, // Default: null
 *         host?: scalar|Param|null, // Default: null
 *         port?: scalar|Param|null, // Default: 514
 *         config?: list<scalar|Param|null>,
 *         members?: list<scalar|Param|null>,
 *         connection_string?: scalar|Param|null,
 *         timeout?: scalar|Param|null,
 *         time?: scalar|Param|null, // Default: 60
 *         deduplication_level?: scalar|Param|null, // Default: 400
 *         store?: scalar|Param|null, // Default: null
 *         connection_timeout?: scalar|Param|null,
 *         persistent?: bool|Param,
 *         dsn?: scalar|Param|null,
 *         hub_id?: scalar|Param|null, // Default: null
 *         client_id?: scalar|Param|null, // Default: null
 *         auto_log_stacks?: scalar|Param|null, // Default: false
 *         release?: scalar|Param|null, // Default: null
 *         environment?: scalar|Param|null, // Default: null
 *         message_type?: scalar|Param|null, // Default: 0
 *         parse_mode?: scalar|Param|null, // Default: null
 *         disable_webpage_preview?: bool|Param|null, // Default: null
 *         disable_notification?: bool|Param|null, // Default: null
 *         split_long_messages?: bool|Param, // Default: false
 *         delay_between_messages?: bool|Param, // Default: false
 *         topic?: int|Param, // Default: null
 *         factor?: int|Param, // Default: 1
 *         tags?: Param|string|list<scalar|Param|null>,
 *         console_formater_options?: mixed, // Deprecated: "monolog.handlers..console_formater_options.console_formater_options" is deprecated, use "monolog.handlers..console_formater_options.console_formatter_options" instead.
 *         console_formatter_options?: mixed, // Default: []
 *         formatter?: scalar|Param|null,
 *         nested?: bool|Param, // Default: false
 *         publisher?: Param|string|array{
 *             id?: scalar|Param|null,
 *             hostname?: scalar|Param|null,
 *             port?: scalar|Param|null, // Default: 12201
 *             chunk_size?: scalar|Param|null, // Default: 1420
 *             encoder?: "json"|"compressed_json"|Param,
 *         },
 *         mongo?: Param|string|array{
 *             id?: scalar|Param|null,
 *             host?: scalar|Param|null,
 *             port?: scalar|Param|null, // Default: 27017
 *             user?: scalar|Param|null,
 *             pass?: scalar|Param|null,
 *             database?: scalar|Param|null, // Default: "monolog"
 *             collection?: scalar|Param|null, // Default: "logs"
 *         },
 *         mongodb?: Param|string|array{
 *             id?: scalar|Param|null, // ID of a MongoDB\Client service
 *             uri?: scalar|Param|null,
 *             username?: scalar|Param|null,
 *             password?: scalar|Param|null,
 *             database?: scalar|Param|null, // Default: "monolog"
 *             collection?: scalar|Param|null, // Default: "logs"
 *         },
 *         elasticsearch?: Param|string|array{
 *             id?: scalar|Param|null,
 *             hosts?: list<scalar|Param|null>,
 *             host?: scalar|Param|null,
 *             port?: scalar|Param|null, // Default: 9200
 *             transport?: scalar|Param|null, // Default: "Http"
 *             user?: scalar|Param|null, // Default: null
 *             password?: scalar|Param|null, // Default: null
 *         },
 *         index?: scalar|Param|null, // Default: "monolog"
 *         document_type?: scalar|Param|null, // Default: "logs"
 *         ignore_error?: scalar|Param|null, // Default: false
 *         redis?: Param|string|array{
 *             id?: scalar|Param|null,
 *             host?: scalar|Param|null,
 *             password?: scalar|Param|null, // Default: null
 *             port?: scalar|Param|null, // Default: 6379
 *             database?: scalar|Param|null, // Default: 0
 *             key_name?: scalar|Param|null, // Default: "monolog_redis"
 *         },
 *         predis?: Param|string|array{
 *             id?: scalar|Param|null,
 *             host?: scalar|Param|null,
 *         },
 *         from_email?: scalar|Param|null,
 *         to_email?: Param|string|list<scalar|Param|null>,
 *         subject?: scalar|Param|null,
 *         content_type?: scalar|Param|null, // Default: null
 *         headers?: list<scalar|Param|null>,
 *         mailer?: scalar|Param|null, // Default: null
 *         email_prototype?: Param|string|array{
 *             id?: scalar|Param|null,
 *             method?: scalar|Param|null, // Default: null
 *         },
 *         lazy?: bool|Param, // Default: true
 *         verbosity_levels?: array{
 *             VERBOSITY_QUIET?: scalar|Param|null, // Default: "ERROR"
 *             VERBOSITY_NORMAL?: scalar|Param|null, // Default: "WARNING"
 *             VERBOSITY_VERBOSE?: scalar|Param|null, // Default: "NOTICE"
 *             VERBOSITY_VERY_VERBOSE?: scalar|Param|null, // Default: "INFO"
 *             VERBOSITY_DEBUG?: scalar|Param|null, // Default: "DEBUG"
 *         },
 *         channels?: Param|string|array{
 *             type?: scalar|Param|null,
 *             elements?: list<scalar|Param|null>,
 *             ...<string, mixed>
 *         },
 *         ...<string, mixed>
 *     }>,
 * }
 * @psalm-type DebugConfig = array{
 *     max_items?: int|Param, // Max number of displayed items past the first level, -1 means no limit. // Default: 2500
 *     min_depth?: int|Param, // Minimum tree depth to clone all the items, 1 is default. // Default: 1
 *     max_string_length?: int|Param, // Max length of displayed strings, -1 means no limit. // Default: -1
 *     dump_destination?: scalar|Param|null, // A stream URL where dumps should be written to. // Default: null
 *     theme?: "dark"|"light"|Param, // Changes the color of the dump() output when rendered directly on the templating. "dark" (default) or "light". // Default: "dark"
 * }
 * @psalm-type ConfigType = array{
 *     imports?: ImportsConfig,
 *     parameters?: ParametersConfig,
 *     services?: ServicesConfig,
 *     pimcore_generic_execution_engine?: PimcoreGenericExecutionEngineConfig,
 *     pimcore_custom_reports?: PimcoreCustomReportsConfig,
 *     pimcore_generic_data_index?: PimcoreGenericDataIndexConfig,
 *     pimcore_studio_backend?: PimcoreStudioBackendConfig,
 *     pimcore_studio_ui?: PimcoreStudioUiConfig,
 *     framework?: FrameworkConfig,
 *     monolog?: MonologConfig,
 *     debug?: DebugConfig,
 *     "when@dev"?: array{
 *         imports?: ImportsConfig,
 *         parameters?: ParametersConfig,
 *         services?: ServicesConfig,
 *         pimcore_generic_execution_engine?: PimcoreGenericExecutionEngineConfig,
 *         pimcore_custom_reports?: PimcoreCustomReportsConfig,
 *         pimcore_generic_data_index?: PimcoreGenericDataIndexConfig,
 *         pimcore_studio_backend?: PimcoreStudioBackendConfig,
 *         pimcore_studio_ui?: PimcoreStudioUiConfig,
 *     },
 *     ...<string, ExtensionType|array{ // extra keys must follow the when@%env% pattern or match an extension alias
 *         imports?: ImportsConfig,
 *         parameters?: ParametersConfig,
 *         services?: ServicesConfig,
 *         ...<string, ExtensionType>,
 *     }>
 * }
 */
final class App
{
    /**
     * @param ConfigType $config
     *
     * @psalm-return ConfigType
     */
    public static function config(array $config): array
    {
        /** @var ConfigType $config */
        $config = AppReference::config($config);

        return $config;
    }
}

namespace Symfony\Component\Routing\Loader\Configurator;

/**
 * This class provides array-shapes for configuring the routes of an application.
 *
 * Example:
 *
 *     ```php
 *     // config/routes.php
 *     namespace Symfony\Component\Routing\Loader\Configurator;
 *
 *     return Routes::config([
 *         'controllers' => [
 *             'resource' => 'routing.controllers',
 *         ],
 *     ]);
 *     ```
 *
 * @psalm-type RouteConfig = array{
 *     path: string|array<string,string>,
 *     controller?: string,
 *     methods?: string|list<string>,
 *     requirements?: array<string,string>,
 *     defaults?: array<string,mixed>,
 *     options?: array<string,mixed>,
 *     host?: string|array<string,string>,
 *     schemes?: string|list<string>,
 *     condition?: string,
 *     locale?: string,
 *     format?: string,
 *     utf8?: bool,
 *     stateless?: bool,
 * }
 * @psalm-type ImportConfig = array{
 *     resource: string,
 *     type?: string,
 *     exclude?: string|list<string>,
 *     prefix?: string|array<string,string>,
 *     name_prefix?: string,
 *     trailing_slash_on_root?: bool,
 *     controller?: string,
 *     methods?: string|list<string>,
 *     requirements?: array<string,string>,
 *     defaults?: array<string,mixed>,
 *     options?: array<string,mixed>,
 *     host?: string|array<string,string>,
 *     schemes?: string|list<string>,
 *     condition?: string,
 *     locale?: string,
 *     format?: string,
 *     utf8?: bool,
 *     stateless?: bool,
 * }
 * @psalm-type AliasConfig = array{
 *     alias: string,
 *     deprecated?: array{package:string, version:string, message?:string},
 * }
 * @psalm-type RoutesConfig = array{
 *     "when@dev"?: array<string, RouteConfig|ImportConfig|AliasConfig>,
 *     ...<string, RouteConfig|ImportConfig|AliasConfig>
 * }
 */
final class Routes
{
    /**
     * @param RoutesConfig $config
     *
     * @psalm-return RoutesConfig
     */
    public static function config(array $config): array
    {
        return $config;
    }
}
