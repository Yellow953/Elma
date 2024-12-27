<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debit Note</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
    @php
    $company = Helper::get_company();
    @endphp

    <div class="container mt-3">
        <a href="{{ url()->previous() }}" class="btn btn-secondary px-3 py-2 mb-3">
            <i class="fa-solid fa-chevron-left"></i> Back </a>

        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-6">
                                <h1 class="text-primary">{{ ucwords($cdnote->type) }}</h1>
                            </div>
                            <div class="col-6 text-end">
                                <strong>No: </strong> {{ $cdnote->cdnote_number }} <br>
                                <strong>Date:</strong> {{ $cdnote->date }}
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-6">
                                <div class="card border-0">
                                    <div class="card-header bg-secondary text-white">
                                        From
                                    </div>
                                    <div class="card-body">
                                        {{ ucwords($company->name) }} <br>
                                        {{ $company->address }} <br>
                                        {{ $company->phone }} <br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card border-0">
                                    <div class="card-header bg-secondary text-white">
                                        To
                                    </div>
                                    <div class="card-body">
                                        {{ ucwords($cdnote->supplier->name) }} <br>
                                        {{ $cdnote->supplier->address }} <br>
                                        {{ $cdnote->supplier->phone }} <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-4">
                                <div class="card border-0">
                                    <div class="card-header bg-secondary text-white">
                                        Amount
                                    </div>
                                    <div class="card-body">
                                        {{ $cdnote->currency->symbol }}{{ number_format($total, 2) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="card border-0">
                                    <div class="card-header bg-secondary text-white">
                                        Amount In Words
                                    </div>
                                    <div class="card-body">
                                        {{ Helper::format_currency_to_words($cdnote->currency->symbol .
                                        number_format($total,
                                        2)) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12">
                                <div class="card border-0">
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
</body>

</html>