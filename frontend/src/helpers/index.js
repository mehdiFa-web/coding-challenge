/**
 * Iterate over object and get key & value to do something with
 */
export function forEach(object,callback) {
    for (const [key, value] of Object.entries(object)) {
        if(!value) continue
        callback(key,value)
    }
}
