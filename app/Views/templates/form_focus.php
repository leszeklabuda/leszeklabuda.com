<script>
    (() => {
        const formControl = document.querySelector('.form-control.failure');
        if (formControl) {
            const fields = ['input', 'textarea'];
            for (const field of fields) {
                const element = formControl.querySelector(field);
                if (element) {
                    element.focus();
                    element.selectionStart = element.selectionEnd = element.value.length;
                    return true;
                }
            }
        } else {
            const formControl = document.querySelector('.form-control.success');
            if (formControl) {
                const hidden = document.querySelector('a.logo');
                if (hidden) {
                    hidden.focus();
                }
            }
        }
    })();
</script>