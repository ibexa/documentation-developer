(function (global) {
    if (CKEDITOR.plugins.get('date')) {
        return;
    }

    const InsertDate = {
        exec: function (editor) {
            const now = new Date();
            editor.insertHtml( now.toString() );
        },
    };
    
    global.CKEDITOR.plugins.add('date', {
        init: (editor) => editor.addCommand('InsertDate', InsertDate),
    });
})(window);
