{{$register = Package.R3m.Io.Autoload:Init:register()}}
{{if(!is.empty($register))}}
{{Package.R3m.Io.Autoload:Import:role.system()}}
{{Package.R3m.Io.Autoload:Import:config.email()}}
{{Package.R3m.Io.Autoload:Import:config.framework()}}
{{Package.R3m.Io.Autoload:Import:config.ramdisk()}}
{{Package.R3m.Io.Autoload:Import:config.response()}}
{{Package.R3m.Io.Autoload:Import:config.service()}}
{{Package.R3m.Io.Autoload:Import:config()}}
{{/if}}