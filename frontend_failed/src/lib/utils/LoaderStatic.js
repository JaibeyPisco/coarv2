let Loader = {

    require : function (file, callback) {
        callback = callback ||
        function () {};
        var filenode;
        var jsfile_extension = /(.js)$/i;
        var cssfile_extension = /(.css)$/i;
    
        if (jsfile_extension.test(file)) {
            filenode = document.createElement('script');
            filenode.src = file;
            // IE
            filenode.onreadystatechange = function () {
                if (filenode.readyState === 'loaded' || filenode.readyState === 'complete') {
                    filenode.onreadystatechange = null;
                    callback();
                }
            };
            // others
            filenode.onload = function () {
                callback();
            };
            document.head.appendChild(filenode);
        } else if (cssfile_extension.test(file)) {
            filenode = document.createElement('link');
            filenode.rel = 'stylesheet';
            filenode.type = 'text/css';
            filenode.href = file;
            document.head.appendChild(filenode);
            callback();
        } else {
            console.log("Unknown file type to load."+ file)
        }
    },

    requireFiles: function () {
        var index = 0;
        return function (files, callback) {
            index += 1;
            Loader.require(files[index - 1], callBackCounter);

            function callBackCounter() {
                if (index === files.length) {
                    index = 0;
                    callback();
                } else {
                    Loader.requireFiles(files, callback);
                }
            };
        };
    }()

};

export default Loader;