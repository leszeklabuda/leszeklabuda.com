    <script>
        window.addEventListener('DOMContentLoaded', () => {
            console.log('DOMContentLoaded');
        });

        window.addEventListener('load', () => {
            console.log('load');
            document.querySelector('html').classList.add('load');
        });

        // Lock the button after submitting the form.
        document.querySelectorAll('form').forEach(element => {
            element.addEventListener('submit', e => {
                const input = e.target.querySelector('input[type="submit"]');
                if(input) {
                    input.setAttribute('disabled', '')
                };
            });
        });
        console.log('DOM parsed');
    </script>
</body>
</html>