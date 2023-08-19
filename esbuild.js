import * as esbuild from "esbuild"
import * as Path from "node:path"
import * as Fs from "node:fs"
import phpManifestPlugin from "esbuild-plugin-php-manifest"

const workingDir = "public_html"

function getEntries(dir) {
    return Fs.readdirSync(Path.join(workingDir, dir)).map(file => Path.join(dir, file))
}

let external = [ 'woff', 'png', 'woff2', 'webp', 'jpeg', 'jpg', 'ttf' ]

const jsPath = "js"
const cssPath = 'css'

let entryPoints = getEntries(jsPath)
entryPoints = entryPoints.concat(getEntries(cssPath))

external = external.map(path => '*.' + path)

const logPlugin = {
    name: "log-plugin",

    setup(build) {
        build.onEnd(result => {
            console.log(result)
        })
    }
}

esbuild.build({
    entryPoints,
    external,
    outbase: '.',
    absWorkingDir: Path.resolve(workingDir),
    allowOverwrite: true,
    entryNames: '[dir]/[name]-[hash]',
    bundle: true,
    minify: true,
    outdir: "bundle",
    metafile: true,
    plugins: [
        phpManifestPlugin({
            pathPHPManifest: Path.join("src/config", "manifest.php")
        }),
        logPlugin
    ]
})

