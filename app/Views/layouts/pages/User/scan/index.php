<?= $this->extend('layouts/base_employee') ?>

<?= $this->section('styles') ?>
    <style>
        .scan {
            position: absolute;
            z-index: 2;
            width: 60%;
            height: 200px;
            margin: 0;
            background: transparent;
            border: 2px solid #ffffff;
            border-style: dashed
        }

        .caption {
            position: absolute;
            font-size: 12px;
            color: #fff;
            z-index: 1;
            width: 100%;
            text-align: center;
        }

        @media only screen and (min-width: 600px) {
            .scan {
                width: 60%;
                height: 400px;
            }
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section>
        <div style="display: flex; justify-content: center; position: relative; text-align: center; align-items: center">
            <div class="card scan"></div>
            <h5 class="caption">
                Please scan QR
                Code inside this square</h5>
            <video id="preview" width="100%"
                   style="object-fit: fill; z-index: 0; height: 80vh; border-radius: 10px"></video>
        </div>
    </section>

    <form id="myForm" name="myForm" action="<?php echo base_url(); ?>/user/scan/submit" method="post"
          style="visibility:hidden">
    </form>

    <script type="text/javascript">
        //regular expressions to extract IP and country values
        const countryCodeExpression = /loc=([\w]{2})/;
        const userIPExpression = /ip=([\w\.]+)/;
        let IP = '';

        //automatic country determination.
        function initCountry() {
            return new Promise((resolve, reject) => {
                let xhr = new XMLHttpRequest();
                xhr.timeout = 3000;
                xhr.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            const countryCode = countryCodeExpression.exec(this.responseText)
                            const ip = userIPExpression.exec(this.responseText)
                            if (countryCode === null || countryCode[1] === '' ||
                                ip === null || ip[1] === '') {
                                reject('IP/Country code detection failed');
                            }
                            let result = {
                                countryCode: countryCode[1],
                                IP: ip[1]
                            };
                            resolve(result)
                            IP = ip[1]
                            document.getElementById("ip").innerHTML = "IP Address : " + result.IP
                        } else {
                            reject(xhr.status)
                        }
                    }
                }
                xhr.ontimeout = function () {
                    reject('timeout')
                }
                xhr.open('GET', 'https://www.cloudflare.com/cdn-cgi/trace', true);
                xhr.send();
            });
        }

        initCountry().then(result => console.log(JSON.stringify(result))).catch(e => console.log(e))


        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview'),
            mirror: false,
            captureImage: true,
            backgroundScan: true
        });

        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                if (!cameras[1]) {
                    scanner.start(cameras[0]);
                } else {
                    scanner.start(cameras[1]);
                }
            } else {
                alert('No cameras found.');
            }
            scanner.addListener('scan', function (content) {
                console.log({IP})
                if ('<?= $qrToday ?>' === content) {
                    if (IP == '180.250.22.66') { //36.70.255.126
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Scan Successfully!',
                            showConfirmButton: false,
                            timer: 3000,
                            heightAuto: false,
                        }).then(() => {
                            $(document).ready(function () {
                                $("#myForm").submit();
                            });
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'You must be in the office area!',
                            showConfirmButton: false,
                            timer: 3000,
                            heightAuto: false,
                        })
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'QR Code does not match!',
                        showConfirmButton: false,
                        timer: 3000,
                        heightAuto: false,
                    })
                }
            }).catch(function (e) {
                alert(e);
                console.error(e);
            });
        });
    </script>

<?= $this->endSection() ?>