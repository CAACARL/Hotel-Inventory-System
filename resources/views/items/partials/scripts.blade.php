<script>
    // Debug form submission
    document.addEventListener('DOMContentLoaded', function() {
        const createForm = document.getElementById('createItemForm');
        if (createForm) {
            createForm.addEventListener('submit', function(e) {
                console.log('Form submission detected');
                console.log('Form data:', new FormData(createForm));
                
                // Let the form submit normally
                return true;
            });
        }
    });
    
    // No additional JavaScript needed for recursive categories
    // All category selection is handled in the dropdown directly
</script>
