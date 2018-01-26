<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,viewport-fit=cover">
    <title>Paiement</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body, html {
            height: 100%;
            background-color: #f7f8f9;
            color: #6b7c93;
        }

        *, label {
            font-family: "Helvetica Neue", Helvetica, sans-serif;
            font-size: 16px;
            font-variant: normal;
            padding: 0;
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        button {
            width: 100%;
            border: none;
            border-radius: 4px;
            outline: none;
            text-decoration: none;
            color: #fff;
            background: #32325d;
            white-space: nowrap;
            display: inline-block;
            height: 40px;
            line-height: 40px;
            padding: 0 14px;
            box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
            border-radius: 4px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.025em;
            text-decoration: none;
            -webkit-transition: all 150ms ease;
            transition: all 150ms ease;
            float: left;
        }

        button:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, .10), 0 3px 6px rgba(0, 0, 0, .08);
            background-color: #43458b;
        }

        form {
            padding: 30px;
            height: 120px;
        }

        label {
            font-weight: 500;
            font-size: 14px;
            display: block;
            margin-bottom: 8px;
        }

        #card-errors {
            height: 20px;
            padding: 4px 0;
            color: #fa755a;
        }

        .StripeElement {
            background-color: white;
            padding: 10px 12px;
            border-radius: 4px;
            border: 1px solid transparent;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
</head>
<body>
    <form action="payment-processing.php" method="post" id="payment-form">
        <div class="form-row">
            <label for="card-element">
                Carte bancaire
            </label>
            <div id="card-element">
                <!-- a Stripe Element will be inserted here. -->
            </div>

            <div id="card-errors" role="alert"></div>
        </div>
        <input type="hidden" name="psid" value="<?php echo $_GET['psid'] ?>">

        <button>Payer <?php echo number_format($_GET['total'], 2, '.', '')." €" ?></button>
    </form>
    <script>
        var stripe = Stripe('pk_test_W62SvGUHvFzzfU6RWax2BAMH');
        var elements = stripe.elements({
            locale: 'fr',
        });

        var card = elements.create('card', {
            style: {
                base: {
                    color: '#32325d',
                    lineHeight: '18px',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            },
            hidePostalCode: true,
        });
        card.mount('#card-element');

        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Create a token or display an error when the form is submitted.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var btn = document.querySelector('button');
            btn.setAttribute("disabled", "");

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the customer that there was an error
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.com/en_US/messenger.Extensions.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'Messenger'));
    </script>
</body>
</html>