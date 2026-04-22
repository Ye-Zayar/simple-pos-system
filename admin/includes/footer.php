
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">
                                © <?= date('Y'); ?> YZT Company. All rights reserved.
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="assets/js/scripts.js"></script>
       
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="assets/js/datatables-simple-demo.js"></script>

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <!-- jsPDF CDN Link -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/3.0.3/jspdf.umd.min.js" integrity="sha512-+EeCylkt9WHJk5tGJxYdecHOcXFRME7qnbsfeMsdQL6NUPYm2+uGFmyleEqsmVoap/f3dN/sc3BX9t9kHXkHHg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!--end jsPDF CDN Link -->

        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
        <script src="assets/js/custom.js"></script>

        <!-- Chart js CDN-->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            if(document.getElementById('mainChart')) {
                const ctx = document.getElementById('mainChart');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: window.chartLabels,
                        datasets: [
                            {
                                label: 'Orders',
                                data: window.chartOrders,
                                borderWidth: 1,
                                tension: 0.4
                            },
                            {
                                 label: 'Customers',
                                data: window.chartCustomers,
                                borderWidth: 1,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false 
                    }
                })
            }
        </script>

    </body>
</html>