import * as Fs from "node:fs"
import * as Path from "node:path"

const jsPath = "js"
const cssPath = 'css'

function getJsEntries(dir) {
    return Fs.readdirSync(dir).map(file => Path.join(dir, file))
}

console.log(getJsEntries("./public_html/js"))
