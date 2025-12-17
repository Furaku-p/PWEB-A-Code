<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Submit Form</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { background: radial-gradient(1200px 600px at 10% 10%, #e9f2ff 0%, #f8f9fb 45%, #ffffff 100%); }
        .card { border: 0; border-radius: 1.25rem; }
        .soft-shadow { box-shadow: 0 10px 30px rgba(0,0,0,.08); }
        .form-control, .btn { border-radius: .9rem; }
        .btn-primary { padding: .85rem 1rem; }
        .fade-in { animation: fadeIn .25s ease-out; }
        @keyframes fadeIn { from {opacity:0; transform: translateY(4px);} to {opacity:1; transform:none;} }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card soft-shadow">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h1 class="h4 mb-1">Contact Form</h1>
                                <p class="text-muted mb-0">Submit tanpa refresh (AJAX + PHP).</p>
                            </div>
                            <span class="badge text-bg-light border">v1</span>
                        </div>

                        <div id="alertBox" class="alert d-none fade-in" role="alert"></div>

                        <form id="contactForm" novalidate>
                            <div class="mb-3">
                                <label class="form-label" for="name">Name</label>
                                <input class="form-control" id="name" name="name" required autocomplete="name" placeholder="Nama Kamu" />
                                <div class="invalid-feedback">Nama wajib diisi.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" id="email" name="email" type="email" required autocomplete="email" placeholder="nama@email.com" />
                                <div class="invalid-feedback">Email tidak valid.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="message">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="4" required placeholder="Tulis pesan..."></textarea>
                                <div class="invalid-feedback">Pesan wajib diisi.</div>
                            </div>

                            <button id="submitBtn" class="btn btn-primary w-100" type="submit">
                                <span id="btnText">Send</span>
                                <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2 d-none" aria-hidden="true"></span>
                            </button>

                        </form>
                    </div>
                </div>

                <div class="text-center mt-3 text-muted small">
                    © <?= date('Y') ?> • Submit Form
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
    const $form = $("#contactForm");
    const $alert = $("#alertBox");
    const $btn = $("#submitBtn");
    const $btnText = $("#btnText");
    const $spinner = $("#btnSpinner");

    function showAlert(type, msg) {
        $alert
        .removeClass("d-none alert-success alert-danger alert-warning")
        .addClass("alert-" + type)
        .text(msg);
    }

    function setLoading(isLoading) {
        $btn.prop("disabled", isLoading);
        $spinner.toggleClass("d-none", !isLoading);
        $btnText.text(isLoading ? "Sending..." : "Send");
    }

    $form.on("submit", function(e){
        e.preventDefault();

        if (this.checkValidity() === false) {
            e.stopPropagation();
            $form.addClass("was-validated");
            return;
        }

        $alert.addClass("d-none");
        setLoading(true);

        $.ajax({
            url: "submit.php",
            method: "POST",
            data: $form.serialize(),
            dataType: "json",
            timeout: 10000,

            success: function(res){
                if (res && res.ok) {
                    showAlert("success", res.message || "Berhasil dikirim ✅");
                    $form[0].reset();
                    $form.removeClass("was-validated");
                } else {
                    showAlert("danger", (res && res.message) ? res.message : "Gagal mengirim.");
                }
            },

            error: function(xhr){
                let msg = "Terjadi error. Coba lagi.";
                // Kalau server ngirim JSON error
                try {
                    const j = JSON.parse(xhr.responseText);
                    if (j && j.message) msg = j.message;
                } catch(_) {}
                showAlert("danger", msg);
            },

            complete: function(){
                setLoading(false);
            }
        });
    });
    </script>
</body>
</html>
