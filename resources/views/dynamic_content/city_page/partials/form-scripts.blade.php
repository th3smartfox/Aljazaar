<script>
    (function () {
        const container = document.getElementById('cityRows');
        if (!container) return;

        const template = document.getElementById('city-row-template').innerHTML.trim();
        const addButton = document.getElementById('addCityRow');
        const searchUrl = container.dataset.searchUrl;
        let nextIndex = parseInt(container.dataset.nextIndex, 10) || container.querySelectorAll('.city-card').length;

        addButton?.addEventListener('click', function () {
            addCityRow();
        });

        container.addEventListener('click', function (event) {
            if (event.target.closest('.remove-city-row')) {
                const row = event.target.closest('.city-card');
                row.remove();
                if (container.querySelectorAll('.city-card').length === 0) {
                    addCityRow();
                } else {
                    reorderRowNumbers();
                }
            }

            if (event.target.classList.contains('city-search-button')) {
                const row = event.target.closest('.city-card');
                searchCities(row);
            }

            if (event.target.classList.contains('city-result-item')) {
                const row = event.target.closest('.city-card');
                selectCity(row, event.target.dataset.cityId, event.target.dataset.cityName);
            }
        });

        container.addEventListener('keydown', function (event) {
            if (event.target.classList.contains('city-search-input') && event.key === 'Enter') {
                event.preventDefault();
                const row = event.target.closest('.city-card');
                searchCities(row);
            }
        });

        container.addEventListener('change', function (event) {
            if (event.target.classList.contains('city-image-input')) {
                updatePreview(event.target);
            }
        });

        document.addEventListener('click', function (event) {
            if (!event.target.closest('.city-search-container')) {
                hideAllSearchResults();
            }
        });

        function addCityRow() {
            const html = template
                .replace(/__INDEX__/g, nextIndex)
                .replace(/__ROW__/g, container.querySelectorAll('.city-card').length + 1);

            const wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            container.appendChild(wrapper.firstElementChild);
            nextIndex++;
        }

        function reorderRowNumbers() {
            container.querySelectorAll('.city-card').forEach((row, index) => {
                const badge = row.querySelector('.city-row-number');
                if (badge) badge.textContent = index + 1;
            });
        }

        async function searchCities(row) {
            const input = row.querySelector('.city-search-input');
            const query = input.value.trim();
            const resultsContainer = row.querySelector('.city-search-results');

            if (query.length < 2) {
                hideAllSearchResults();
                resultsContainer.classList.remove('d-none');
                showSearchMessage(resultsContainer, 'Type at least 2 characters.');
                return;
            }

            hideAllSearchResults();
            resultsContainer.classList.remove('d-none');
            showSearchMessage(resultsContainer, 'Searching...');

            try {
                const response = await fetch(`${searchUrl}?query=${encodeURIComponent(query)}`);
                if (!response.ok) {
                    throw new Error('Failed to fetch results');
                }

                const data = await response.json();
                if (!Array.isArray(data) || data.length === 0) {
                    showSearchMessage(resultsContainer, 'No cities found.');
                    return;
                }

                resultsContainer.innerHTML = data.map(city => `
                    <button type="button" class="city-result-item" data-city-id="${city.id}" data-city-name="${city.name}">
                        ${city.name}
                    </button>
                `).join('');
            } catch (error) {
                console.error(error);
                showSearchMessage(resultsContainer, 'Unable to load cities, please try again.');
            }
        }

        function showSearchMessage(container, message) {
            container.innerHTML = `<div class="p-3 text-muted small">${message}</div>`;
        }

        function hideAllSearchResults() {
            container.querySelectorAll('.city-search-results').forEach((panel) => {
                panel.classList.add('d-none');
            });
        }

        function selectCity(row, cityId, cityName) {
            row.querySelector('.city-id-input').value = cityId;
            row.querySelector('.city-selected-name').textContent = cityName;

            const results = row.querySelector('.city-search-results');
            results.classList.add('d-none');
            results.innerHTML = '';
        }

        function updatePreview(input) {
            const previewId = input.getAttribute('data-preview-target');
            if (!previewId) return;

            const preview = document.getElementById(previewId);
            if (!preview) return;

            const file = input.files?.[0];
            if (!file) {
                preview.classList.add('d-none');
                preview.innerHTML = '<span class="text-muted small">No image selected yet</span>';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (event) {
                preview.classList.remove('d-none');
                preview.innerHTML = `<img src="${event.target.result}" alt="City image preview" class="img-fluid rounded-3 shadow-sm">`;
            };
            reader.readAsDataURL(file);
        }
    })();
</script>

