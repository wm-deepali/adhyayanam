<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Payment {{ $req->txStatus }}</title>
  </head>
  <body>
    <div class="container mt-2">
        <div class="card card-primary">
            <div class="card-header">

                <div class="card-title">Card Title</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">Order Amount</div>
                    <div class="col-md-6">{{ $req->orderAmount }}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">Order ID</div>
                    <div class="col-md-6">{{ $req->orderId }}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">Payment Mode</div>
                    <div class="col-md-6">{{ $req->paymentMode }}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">Reference ID</div>
                    <div class="col-md-6">{{ $req->referenceId }}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">Signature</div>
                    <div class="col-md-6">{{ $req->signature }}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">Txn Message</div>
                    <div class="col-md-6">{{ $req->txMsg }}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">Txn Status</div>
                    <div class="col-md-6">{{ $req->txStatus }}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">Txn Time</div>
                    <div class="col-md-6">{{ $req->txTime }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>