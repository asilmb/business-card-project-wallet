export const rules = {
    required: value => !!value || 'Field is required.',
    minLength: value => (value && value.length >= 8) || 'Must be at least 8 characters.',
    email: value => /.+@.+\..+/.test(value) || 'E-mail must be valid.',
}