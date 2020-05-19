const convertToCSV = (data) => {
    const blob = new Blob([data], {type: 'csv', encoding: 'UTF-8'})
    const link = document.createElement('a')
    link.href = window.URL.createObjectURL(blob)
    link.download = 'shelf-location.csv'
    link.click()
}

export const CSV = {convertToCSV}
