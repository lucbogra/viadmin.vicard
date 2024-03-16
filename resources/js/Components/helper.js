const getIcon = (file) => {
        
    const ext = file.split('.').pop()

    if (['pdf', 'PDF'].includes(ext)) {

        return 'bi:file-earmark-pdf'

    } else if (['jpeg', 'jpg', 'JPEG', 'JPG', 'png', 'PNG'].includes(ext)) {

        return 'bi:file-earmark-image'
        
    }

    return 'pepicons-print:file'

}

export { 
    getIcon
}