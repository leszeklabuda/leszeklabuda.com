<?= $this->extend(setting('Pages.views')['layout']) ?>

<?= $this->section('title') ?><?= lang('Pages.home') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>
<article class="epoch-unix-timestamp">
    <h1>The Current Epoch Unix Timestamp</h1>
    <p class="timestamp"></p>
    <p>SECONDS SINCE JAN 01 1970. (UTC)</p>
    <p><em>Source: <a href="http://worldtimeapi.org/" target="_blank">http://worldtimeapi.org/</a></em></p>
    <script>
        (async () => {
            const url = 'https://worldtimeapi.org/api/timezone/Etc/UTC/';
            let difference = 0;

            await synchronizeTimestamp();
            setInterval(renderTimestamp, 200);
            setInterval(synchronizeTimestamp, 10000);

            async function synchronizeTimestamp() {
                try {
                    const localTimestamp = getLocalTimestamp();
                    const remoteTimestamp = await getRemoteTimestamp();
                    difference = localTimestamp - remoteTimestamp;
                    console.log(localTimestamp, remoteTimestamp, difference);
                } catch (e) {

                }
            }

            function getLocalTimestamp() {
                return Math.trunc(Date.now() / 1000);
            }

            async function getRemoteTimestamp() {
                const response = await fetch(url);
                if (response.ok) {
                    const data = await response.json();
                    console.log(data);
                    return data.unixtime;
                }
                throw new Error('No response');
            }

            function renderTimestamp() {
                const timestamp = getLocalTimestamp() - difference;
                document.querySelector('p.timestamp').textContent = timestamp;
            }
        })();
    </script>
    <style>
        .epoch-unix-timestamp h1,
        .epoch-unix-timestamp p {
            text-align: center;
        }

        .epoch-unix-timestamp h1 {
            font-size: 1.5rem;
        }

        .epoch-unix-timestamp p.timestamp {
            font-size: 1.5rem;
            padding: 0.5rem;
            border: 1px solid gray;
            border-radius: 0.25rem;
            width: 12rem;
            margin: 0.5rem auto;
        }
    </style>
</article>
<?= $this->endSection() ?>

<?php
