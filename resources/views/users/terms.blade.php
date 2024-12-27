<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{asset('/assets/images/logos/logo.png')}}">

    <title>
        Stockify | Terms And Conditions
    </title>

    <link rel="shortcut icon" href="{{asset('assets/images/logos/logo.png')}}" type="image/x-icon">

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@500&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('/assets/css/material-dashboard.css?v=3.0.2')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('/assets/css/custom.css')}}">
</head>

<body>
    <main class="main-content">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url({{ asset('/assets/images/warehouse.png')}});">
            <div class="container my-auto">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <div class="card">
                            <div class="card-header p-0 position-relative mt-n4 mx-3">
                                <div class="bg-gradient-info shadow-info border-radius-lg py-3 pe-1">
                                    <h4 class="text-dark font-weight-bolder text-center my-2">Terms and Conditions</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('users.terms_agree') }}">
                                    @csrf
                                    <div class="login-form-body">
                                        @include('layouts._flash')

                                        <div style="height: 55vh; overflow: auto;">
                                            <h2>1. Introduction</h2>
                                            <p>Welcome to YellowTech ("Company", "we", "our", "us"). By
                                                accessing or using our inventory/accounting system ("Service"), you
                                                agree to comply with and be bound by these Terms and Conditions
                                                ("Terms"). If you do not agree to these Terms, you must not use our
                                                Service.</p>

                                            <h2>2. Use of Service</h2>
                                            <h3>2.1 Eligibility</h3>
                                            <p>You must be at least 18 years old to use our Service. By using the
                                                Service, you represent and warrant that you have the legal capacity to
                                                enter into a binding agreement.</p>

                                            <h3>2.2 Account Registration</h3>
                                            <p>To use certain features of our Service, you may need to register for an
                                                account. You agree to provide accurate and complete information during
                                                the registration process and to update such information to keep it
                                                accurate and complete.</p>

                                            <h3>2.3 Account Security</h3>
                                            <p>You are responsible for maintaining the confidentiality of your account
                                                credentials and for all activities that occur under your account. You
                                                agree to notify us immediately of any unauthorized use of your account
                                                or any other security breach.</p>

                                            <h2>3. Service Availability</h2>
                                            <h3>3.1 Availability</h3>
                                            <p>We will use reasonable efforts to make the Service available at all
                                                times. However, we do not guarantee that the Service will be
                                                uninterrupted or error-free, and we reserve the right to suspend or
                                                restrict access to the Service for maintenance or other reasons without
                                                prior notice.</p>

                                            <h3>3.2 Changes to Service</h3>
                                            <p>We reserve the right to modify, suspend, or discontinue any part of the
                                                Service at any time with or without notice.</p>

                                            <h2>4. User Responsibilities</h2>
                                            <h3>4.1 Compliance with Laws</h3>
                                            <p>You agree to use the Service in compliance with all applicable laws,
                                                regulations, and guidelines.</p>

                                            <h3>4.2 Prohibited Conduct</h3>
                                            <p>You agree not to:</p>
                                            <ul>
                                                <li>Use the Service for any illegal or unauthorized purpose.</li>
                                                <li>Interfere with or disrupt the integrity or performance of the
                                                    Service.</li>
                                                <li>Attempt to gain unauthorized access to the Service or its related
                                                    systems or networks.</li>
                                                <li>Upload or transmit any harmful code or content.</li>
                                            </ul>

                                            <h2>5. Fees and Payments</h2>
                                            <h3>5.1 Fees</h3>
                                            <p>Access to certain features of the Service may require payment of fees.
                                                All fees are non-refundable unless otherwise stated.</p>

                                            <h3>5.2 Payment</h3>
                                            <p>You agree to pay all fees and charges associated with your use of the
                                                Service in a timely manner. We may use third-party payment processors to
                                                handle such payments.</p>

                                            <h2>6. Intellectual Property</h2>
                                            <h3>6.1 Ownership</h3>
                                            <p>All content, trademarks, service marks, logos, and other intellectual
                                                property used in connection with the Service are the property of the
                                                Company or its licensors.</p>

                                            <h3>6.2 License</h3>
                                            <p>Subject to these Terms, we grant you a limited, non-exclusive,
                                                non-transferable, and revocable license to use the Service for your
                                                internal business purposes.</p>

                                            <h2>7. Data and Privacy</h2>
                                            <h3>7.1 Data Collection</h3>
                                            <p>We may collect and use data as described in our Privacy Policy. By using
                                                the Service, you consent to such collection and use of data.</p>

                                            <h3>7.2 Data Security</h3>
                                            <p>We implement reasonable measures to protect the security of your data.
                                                However, we cannot guarantee absolute security.</p>

                                            <h2>8. Disclaimers and Limitation of Liability</h2>
                                            <h3>8.1 Disclaimers</h3>
                                            <p>The Service is provided "as is" and "as available" without warranties of
                                                any kind, either express or implied. We disclaim all warranties,
                                                including but not limited to the implied warranties of merchantability,
                                                fitness for a particular purpose, and non-infringement.</p>

                                            <h3>8.2 Limitation of Liability</h3>
                                            <p>To the maximum extent permitted by law, we will not be liable for any
                                                indirect, incidental, special, consequential, or punitive damages, or
                                                any loss of profits or revenues, whether incurred directly or
                                                indirectly, or any loss of data, use, goodwill, or other intangible
                                                losses, resulting from (i) your use or inability to use the Service;
                                                (ii) any unauthorized access to or use of our servers and/or any
                                                personal information stored therein; (iii) any interruption or cessation
                                                of transmission to or from the Service; (iv) any bugs, viruses, trojan
                                                horses, or the like that may be transmitted to or through our Service by
                                                any third party; (v) any errors or omissions in any content or for any
                                                loss or damage incurred as a result of the use of any content posted,
                                                emailed, transmitted, or otherwise made available through the Service;
                                                and/or (vi) the defamatory, offensive, or illegal conduct of any third
                                                party.</p>

                                            <h2>9. Indemnification</h2>
                                            <p>You agree to indemnify, defend, and hold harmless the Company, its
                                                affiliates, and their respective officers, directors, employees,
                                                contractors, agents, licensors, and suppliers from and against any
                                                claims, liabilities, damages, judgments, awards, losses, costs,
                                                expenses, or fees (including reasonable attorneys' fees) arising out of
                                                or relating to your violation of these Terms or your use of the Service.
                                            </p>

                                            <h2>10. Termination</h2>
                                            <p>We may terminate or suspend your access to the Service, without prior
                                                notice or liability, for any reason, including if you breach these
                                                Terms. Upon termination, your right to use the Service will immediately
                                                cease.</p>

                                            <h2>11. Governing Law</h2>
                                            <p>These Terms and any disputes arising out of or related to these Terms or
                                                the Service will be governed by and construed in accordance with the
                                                laws of Lebanon, without regard to its conflict of law
                                                principles.</p>

                                            <h2>12. Changes to Terms</h2>
                                            <p>We may update these Terms from time to time. If we make material changes,
                                                we will notify you by email or by posting a notice on our website prior
                                                to the effective date of the changes. Your continued use of the Service
                                                after the effective date of the changes constitutes your acceptance of
                                                the revised Terms.</p>

                                            <h2>13. Contact Information</h2>
                                            <p>If you have any questions about these Terms, please contact us at:</p>
                                            <p>
                                                YellowTech<br>
                                                Lebanon, Beirut<br>
                                                yellow.tech.953@gmail.com
                                            </p>
                                        </div>

                                        @if (!auth()->user()->terms_agreed)
                                        <div class="form-group mt-4">
                                            <input type="checkbox" name="agree" id="agree" class="mx-1" required>
                                            <label for="agree">agree</label>
                                        </div>

                                        <div class="w-100">
                                            <button id="form_submit" class="btn btn-info w-100"
                                                type="submit">Continue</button>
                                        </div>
                                        @else
                                        <div class="w-100 mt-5">
                                            <a href="{{ url()->previous() }}" class="btn btn-secondary w-100">Back</a>
                                        </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>