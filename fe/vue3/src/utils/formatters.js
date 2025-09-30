export function formatCurrency(cents, currencyCode = 'USD') {
    if (typeof cents !== 'number' || !currencyCode) {
        return '';
    }

    const amount = cents / 100;

    return new Intl.NumberFormat(undefined, {
        style: 'currency',
        currency: currencyCode,
    }).format(amount);
}