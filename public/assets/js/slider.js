var thumbs = document.querySelectorAll('.thumb');
thumbs.forEach(function (thumb) {
    thumb.addEventListener('click', function () {
        // Check if the clicked element does not have the 'active' class
        if (!this.classList.contains('active')) {
            // Remove the 'active' class from all elements with the class 'thumb'
            thumbs.forEach(function (el) {
                el.classList.remove('active');
            });
            // Add the 'active' class to the clicked element
            this.classList.add('active');
        }
    });
});