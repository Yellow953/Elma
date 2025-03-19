<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">

    <title>Elma | Credit Note</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .border-custom {
            border: 1px solid rgba(99, 99, 99, 0.5);
        }

        @media print {
            @page {
                size: landscape;
                margin: 0;
            }

            body,
            html {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 0;
            }

            .card {
                border: none;
                box-shadow: none;
                width: 100%;
                page-break-inside: avoid;
            }

            .card-header,
            .card-footer {
                background-color: white !important;
                color: black !important;
            }

            .bg-secondary {
                background-color: white !important;
                color: black !important;
            }

            .text-primary {
                color: black !important;
            }

            .text-end {
                text-align: right !important;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ url()->previous() }}" class="btn btn-secondary px-3 py-2 mb-3">
                <i class="fa-solid fa-chevron-left"></i> Back </a>

            <button onclick="printSection()" class="btn btn-primary mb-3">Print</button>
        </div>

        <div class="row justify-content-center" id="print">
            <div class="col-10">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-4 my-auto">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="Elma Logo" class="img-fluid w-75">
                            </div>
                            <div class="col-4 my-auto text-center">
                                <h1 class="text-primary">{{ ucwords($cdnote->type) }}</h1>
                            </div>
                            <div class="col-4 my-auto text-end">
                                <strong>No: </strong> {{ $cdnote->cdnote_number }} <br>
                                <strong>Date:</strong> {{ $cdnote->date }}
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-6">
                                <div class="card border-custom">
                                    <div class="card-header bg-secondary text-white">
                                        From
                                    </div>
                                    <div class="card-body">
                                        Elma
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card border-custom">
                                    <div class="card-header bg-secondary text-white">
                                        To
                                    </div>
                                    <div class="card-body">
                                        {{ ucwords($cdnote->client->name) }} <br>
                                        {{ $cdnote->client->address }} <br>
                                        {{ $cdnote->client->phone }} <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-4">
                                <div class="card border-custom">
                                    <div class="card-header bg-secondary text-white">
                                        Amount
                                    </div>
                                    <div class="card-body">
                                        {{ $cdnote->currency->symbol }}{{ number_format($cdnote->amount, 2) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="card border-custom">
                                    <div class="card-header bg-secondary text-white">
                                        Amount In Words
                                    </div>
                                    <div class="card-body text-uppercase">
                                        {{ Helper::format_currency_to_words($cdnote->currency->symbol .
                                        number_format($cdnote->amount,
                                        2)) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12">
                                <div class="card border-custom">
                                    <div class="card-header bg-secondary text-white">
                                        Description
                                    </div>
                                    <div class="card-body">
                                        {{ $cdnote->description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        Thank you for your business!
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        function printSection() {
            const section = document.getElementById('print');
            const printWindow = window.open('', '_blank', 'width=842,height=595');
            printWindow.document.open();
            printWindow.document.write(`
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <title>Print Section</title>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
                    <style>
                        @page {
                            size: A5 landscape;
                            margin: 10mm;
                        }

                        body {
                            margin: 0;
                            padding: 0;
                        }

                        .container {
                            width: 100%;
                        }

                        @media print {
                            body {
                                width: 100%;
                                height: 100%;
                                margin: 0;
                                padding: 0;
                            }
                        }
                    </style>
                </head>
                <body onload="window.print();">
                    ${section.outerHTML}
                </body>
                </html>
            `);
            printWindow.document.close();
        }
    </script>
</body>

</html>