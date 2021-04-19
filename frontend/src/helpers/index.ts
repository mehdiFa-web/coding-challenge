interface CustomForEachCallbackParams {
    (key : string ,value: string | Array<string>) : void
}
/**
 * Iterate over object and get key & value to do something with
 */
export function forEach(object: Object,callback:CustomForEachCallbackParams) {
    for (const [key, value] of Object.entries(object)) {
        if(!value) continue
        callback(key,value)
    }
}
