<article class="nbp">
    <h1>Kursy średnie walut NBP</h1>
    <p class="date">Tabela z dnia: <span>---</span></p>
    <table class="exchange-rates"></table>
    <p><em>Source: <a href="http://api.nbp.pl/" target="_blank">http://api.nbp.pl/</a></em></p>
    <script>
        (async () => {
            await update();
            setInterval(update, 10000, true);

            async function update(renew = false) {
                try {
                    const data = await getExchangeRates();
                    console.log('nbp:', data);
                    renderExchangeRates(data, renew);
                } catch (e) {
                    console.warn(e);
                }
            }

            async function getExchangeRates() {
                const url = 'https://api.nbp.pl/api/exchangerates/tables/A/?format=json';
                const response = await fetch(url);
                if (response.ok) {
                    const data = await response.json();
                    return data;
                }
                throw new Error('No response');
            }

            function renderExchangeRates(data, renew) {
                document.querySelector('.nbp .date span').textContent = data[0].effectiveDate || '---';

                const rates = data[0].rates;
                if (!rates) {
                    return;
                }

                const table = document.querySelector('.nbp .exchange-rates');

                if (renew) {
                    while (table.firstChild) {
                        table.removeChild(table.lastChild);
                    }
                }

                const tr = document.createElement('tr');
                const th1 = document.createElement('th');
                const th2 = document.createElement('th');
                const th3 = document.createElement('th');
                th1.textContent = 'Nazwa waluty';
                th2.textContent = 'Kod waluty';
                th3.textContent = 'Kurs średni';
                tr.appendChild(th1);
                tr.appendChild(th2);
                tr.appendChild(th3);
                table.appendChild(tr);

                for (const rate of rates) {
                    const tr = document.createElement('tr');
                    const td1 = document.createElement('td');
                    const td2 = document.createElement('td');
                    const td3 = document.createElement('td');
                    td1.textContent = rate.currency;
                    td2.textContent = rate.code;
                    td3.textContent = rate.mid;
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    table.appendChild(tr);
                }
            }
        })();
    </script>
    <style>
        .nbp h1,
        .nbp p {
            text-align: center;
        }

        .nbp h1 {
            font-size: 1.5rem;
        }

        .nbp p {
            margin: 0.5rem auto;
        }

        .nbp table.exchange-rates {
            margin: 0 auto;
        }

        .nbp table,
        .nbp th,
        .nbp td {
            border: 1px solid gray;
            border-collapse: collapse;
        }

        .nbp th,
        .nbp td {
            padding: 0.25rem 0.5rem;
        }
    </style>
</article>
