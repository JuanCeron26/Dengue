function openAddressModal() {
            document.getElementById('addressModal').classList.remove('hidden');
        }

        function closeAddressModal() {
            document.getElementById('addressModal').classList.add('hidden');
        }

        function saveAddress() {
            const viaType = document.getElementById('viaType').value;
            const mainNumber = document.getElementById('mainNumber').value;
            const secundaryNumber = document.getElementById('secundaryNumber').value;
            const plateNumber = document.getElementById('plateNumber').value;

            if (!viaType || !mainNumber || !secundaryNumber || !plateNumber) {
                alert('Por favor completa todos los campos de la dirección');
                return;
            }

            const fullAddress = `${viaType} ${mainNumber}-${secundaryNumber}-${plateNumber}`;
            document.getElementById('address').value = fullAddress;
            
            // Clear modal fields
            document.getElementById('viaType').value = '';
            document.getElementById('mainNumber').value = '';
            document.getElementById('secundaryNumber').value = '';
            document.getElementById('plateNumber').value = '';
            
            closeAddressModal();
        }

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const siteName = document.getElementById('siteName').value;
            const neighborhood = document.getElementById('neighborhood').value;
            const address = document.getElementById('address').value;

            if (!siteName || !neighborhood || !address) {
                alert('Por favor completa todos los campos');
                return;
            }

            alert('¡Sitio registrado exitosamente!\n\nNombre: ' + siteName + '\nBarrio: ' + neighborhood + '\nDirección: ' + address);

            // Clear form
            document.getElementById('siteName').value = '';
            document.getElementById('neighborhood').value = '';
            document.getElementById('address').value = '';
        });

        // Close modal when clicking outside
        document.getElementById('addressModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddressModal();
            }
        });