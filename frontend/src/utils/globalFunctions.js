export const formatCurrency = (value) => {
    return Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
}

export const stringToFloat = (str) => {
    const cleanValue = str.replace(/[^0-9,-]+/g,"").replace(",", ".");
    return parseFloat(cleanValue);
}

export const floatToPercentage = (value) => {
    return (value * 100).toFixed(2) + '%';
}

export const percentageToFloat = (str) => {
    const cleanValue = str.replace('%', '');
    return parseFloat(cleanValue) / 100;
}
