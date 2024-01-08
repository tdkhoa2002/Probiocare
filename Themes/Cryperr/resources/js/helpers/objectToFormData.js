export function objectToFormData(object, formData = new FormData(), parent = null) {
    for (const property in object) {
        if (object.hasOwnProperty(property)) {
            appendToFormData(formData, getKey(parent, property), object[property]);
        }
    }
    return formData;
}

function getKey(parent, property) {
    return parent ? parent + '[' + property + ']' : property;
}

function appendToFormData(formData, key, value) {
    if (value instanceof Date) {
        return formData.append(key, value.toISOString());
    }

    if (value instanceof File) {
        return formData.append(key, value, value.name);
    }
    if (value === true) {
        return formData.append(key, 1);
    } else if (value === false) {
        return formData.append(key, 0);
    } else if (value === null) {
        return formData.append(key, "");
    } else if (typeof value !== 'object') {
        return formData.append(key, value);
    }
    objectToFormData(value, formData, key);
}
