@extends('layouts.vertical', ['title' => 'Edit Drawer Page Content'])

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .icon-item i.fas {
        font-family: "Font Awesome 6 Free" !important;
        font-weight: 900 !important;
        display: inline-block !important;
        font-style: normal !important;
        font-variant: normal !important;
        text-rendering: auto !important;
        line-height: 1 !important;
    }
    #iconGrid .icon-item {
        min-height: 100px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Drawer Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('drawer-pages.index') }}">Drawer Page</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Edit Drawer Page Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-3" action="{{ route('drawer-pages.update', $drawerPage->id) }}" method="POST" id="drawerPageForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Title -->
                        <div class="col-md-6">
                            <label for="title" class="form-label">App Name (Title)</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title', $drawerPage->title) }}" required>
                        </div>

                        <!-- Status Field -->
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status"
                                id="status" required>
                                <option value="1" {{ old('status', $drawerPage->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $drawerPage->status) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        
                        <hr class="my-4">
                        <h5 class="text-primary mb-3">Button Configuration</h5>
                        
                        @php
                            $buttons = [
                                'button_my_account' => [
                                    'label' => 'My Account Button',
                                    'default_title' => 'My Account',
                                    'default_icon' => 'FontAwesomeIcons.solidUser',
                                    'default_subtitle' => false
                                ],
                                'button_account_tier' => [
                                    'label' => 'Account Tier Button',
                                    'default_title' => 'Account Tier',
                                    'default_icon' => 'FontAwesomeIcons.userShield',
                                    'default_subtitle' => true
                                ],
                                'button_wallet' => [
                                    'label' => 'Wallet Button',
                                    'default_title' => 'Wallet',
                                    'default_icon' => 'FontAwesomeIcons.wallet',
                                    'default_subtitle' => true
                                ],
                                'button_change_information' => [
                                    'label' => 'Change Information Button',
                                    'default_title' => 'Change Information',
                                    'default_icon' => 'FontAwesomeIcons.penToSquare',
                                    'default_subtitle' => true
                                ],
                                'button_order_reordering' => [
                                    'label' => 'Order & Reordering Button',
                                    'default_title' => 'Order & Reordering',
                                    'default_icon' => 'FontAwesomeIcons.cartShopping',
                                    'default_subtitle' => false
                                ],
                                'button_order_tracking' => [
                                    'label' => 'Order Tracking Button',
                                    'default_title' => 'Order Tracking',
                                    'default_icon' => 'FontAwesomeIcons.truck',
                                    'default_subtitle' => false
                                ],
                                'button_active_orders' => [
                                    'label' => 'Active Orders Button',
                                    'default_title' => 'Active Orders',
                                    'default_icon' => 'FontAwesomeIcons.clock',
                                    'default_subtitle' => false
                                ],
                                'button_closed_orders' => [
                                    'label' => 'Closed Orders Button',
                                    'default_title' => 'Closed Orders',
                                    'default_icon' => 'FontAwesomeIcons.circleCheck',
                                    'default_subtitle' => false
                                ],
                                'button_redeem_rewards' => [
                                    'label' => 'Redeem Rewards Button',
                                    'default_title' => 'Redeem Rewards',
                                    'default_icon' => 'FontAwesomeIcons.gift',
                                    'default_subtitle' => false
                                ],
                                'button_messages' => [
                                    'label' => 'Messages Button',
                                    'default_title' => 'Messages',
                                    'default_icon' => 'FontAwesomeIcons.solidMessage',
                                    'default_subtitle' => false
                                ]
                            ];
                        @endphp

                        @foreach($buttons as $buttonKey => $buttonConfig)
                            @php
                                $buttonData = $drawerPage->{$buttonKey} ?? [];
                                if (is_string($buttonData)) {
                                    // Handle old string format
                                    $title = $buttonData;
                                    $icon = $buttonConfig['default_icon'];
                                    $isSubtitle = $buttonConfig['default_subtitle'];
                                } else {
                                    // Handle new JSON format
                                    $title = $buttonData['title'] ?? $buttonConfig['default_title'];
                                    $icon = $buttonData['icon'] ?? $buttonConfig['default_icon'];
                                    $isSubtitle = $buttonData['is_subtitle'] ?? $buttonConfig['default_subtitle'];
                                }
                            @endphp

                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-body">
                                        <h6 class="card-title mb-3">{{ $buttonConfig['label'] }}</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="{{ $buttonKey }}_title" class="form-label">Button Title</label>
                                                <input type="text" name="{{ $buttonKey }}_title" class="form-control"
                                                    id="{{ $buttonKey }}_title" value="{{ old($buttonKey . '_title', $title) }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="{{ $buttonKey }}_icon" class="form-label">Icon</label>
                                                <div class="input-group">
                                                    <input type="text" name="{{ $buttonKey }}_icon" class="form-control icon-input" readonly
                                                        id="{{ $buttonKey }}_icon" value="{{ old($buttonKey . '_icon', $icon) }}" required>
                                                    <button class="btn btn-outline-secondary icon-picker-btn" type="button" data-target="{{ $buttonKey }}_icon">
                                                        <i class="fas fa-icons"></i> Choose
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label d-block">Is Subtitle</label>
                                                <div class="form-check form-switch" style="padding-top: 8px;">
                                                    <input class="form-check-input" type="checkbox" name="{{ $buttonKey }}_is_subtitle" 
                                                        id="{{ $buttonKey }}_is_subtitle" value="1" 
                                                        {{ old($buttonKey . '_is_subtitle', $isSubtitle) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="{{ $buttonKey }}_is_subtitle">
                                                        Enable Subtitle
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Submit Button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Update form</button>
                            <a href="{{ route('drawer-pages.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>

    <!-- Icon Picker Modal -->
    <div class="modal fade" id="iconPickerModal" tabindex="-1" aria-labelledby="iconPickerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="iconPickerModalLabel">Choose an Icon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" id="iconSearch" class="form-control" placeholder="Search icons...">
                    </div>
                    <div class="row g-2" id="iconGrid">
                        <!-- Icons will be populated here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
(function() {
    // Wait for DOM and Bootstrap to be ready
    function initIconPicker() {
        // Font Awesome icons list (commonly used ones)
        const fontAwesomeIcons = [
            { name: 'User', value: 'FontAwesomeIcons.solidUser', class: 'fa-user' },
            { name: 'User Shield', value: 'FontAwesomeIcons.userShield', class: 'fa-user-shield' },
            { name: 'Wallet', value: 'FontAwesomeIcons.wallet', class: 'fa-wallet' },
            { name: 'Pen to Square', value: 'FontAwesomeIcons.penToSquare', class: 'fa-pen-to-square' },
            { name: 'Cart Shopping', value: 'FontAwesomeIcons.cartShopping', class: 'fa-cart-shopping' },
            { name: 'Gift', value: 'FontAwesomeIcons.gift', class: 'fa-gift' },
            { name: 'Message', value: 'FontAwesomeIcons.solidMessage', class: 'fa-message' },
            { name: 'Home', value: 'FontAwesomeIcons.home', class: 'fa-home' },
            { name: 'Bell', value: 'FontAwesomeIcons.bell', class: 'fa-bell' },
            { name: 'Heart', value: 'FontAwesomeIcons.heart', class: 'fa-heart' },
            { name: 'Star', value: 'FontAwesomeIcons.star', class: 'fa-star' },
            { name: 'Location Dot', value: 'FontAwesomeIcons.locationDot', class: 'fa-location-dot' },
            { name: 'Phone', value: 'FontAwesomeIcons.phone', class: 'fa-phone' },
            { name: 'Envelope', value: 'FontAwesomeIcons.envelope', class: 'fa-envelope' },
            { name: 'Gear', value: 'FontAwesomeIcons.gear', class: 'fa-gear' },
            { name: 'Circle User', value: 'FontAwesomeIcons.circleUser', class: 'fa-circle-user' },
            { name: 'Credit Card', value: 'FontAwesomeIcons.creditCard', class: 'fa-credit-card' },
            { name: 'Tag', value: 'FontAwesomeIcons.tag', class: 'fa-tag' },
            { name: 'Bars', value: 'FontAwesomeIcons.bars', class: 'fa-bars' },
            { name: 'Search', value: 'FontAwesomeIcons.search', class: 'fa-search' },
            { name: 'Circle Info', value: 'FontAwesomeIcons.circleInfo', class: 'fa-circle-info' },
            { name: 'Circle Question', value: 'FontAwesomeIcons.circleQuestion', class: 'fa-circle-question' },
            { name: 'Shield Halved', value: 'FontAwesomeIcons.shieldHalved', class: 'fa-shield-halved' },
            { name: 'Clock', value: 'FontAwesomeIcons.clock', class: 'fa-clock' },
            { name: 'Calendar', value: 'FontAwesomeIcons.calendar', class: 'fa-calendar' },
            { name: 'Box', value: 'FontAwesomeIcons.box', class: 'fa-box' },
            { name: 'Truck', value: 'FontAwesomeIcons.truck', class: 'fa-truck' },
            { name: 'Receipt', value: 'FontAwesomeIcons.receipt', class: 'fa-receipt' },
            { name: 'List', value: 'FontAwesomeIcons.list', class: 'fa-list' },
            { name: 'Clipboard', value: 'FontAwesomeIcons.clipboard', class: 'fa-clipboard' },
        ];

        const modalElement = document.getElementById('iconPickerModal');
        if (!modalElement) {
            console.error('Icon picker modal not found');
            return;
        }

        let currentTargetInput = null;
        let modal = null;
        const iconGrid = document.getElementById('iconGrid');
        const iconSearch = document.getElementById('iconSearch');

        // Initialize Bootstrap modal
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            modal = new bootstrap.Modal(modalElement);
        } else if (typeof jQuery !== 'undefined' && jQuery.fn.modal) {
            // Fallback to jQuery Bootstrap modal
            modal = {
                show: function() {
                    jQuery(modalElement).modal('show');
                },
                hide: function() {
                    jQuery(modalElement).modal('hide');
                }
            };
        } else {
            // Fallback: manual modal show/hide
            modal = {
                show: function() {
                    modalElement.style.display = 'block';
                    modalElement.classList.add('show');
                    document.body.classList.add('modal-open');
                    const backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    backdrop.id = 'iconPickerBackdrop';
                    document.body.appendChild(backdrop);
                },
                hide: function() {
                    modalElement.style.display = 'none';
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.getElementById('iconPickerBackdrop');
                    if (backdrop) backdrop.remove();
                }
            };
        }

        // Render icons in the modal
        function renderIcons(filter = '') {
            if (!iconGrid) return;
            
            iconGrid.innerHTML = '';
            const filteredIcons = filter 
                ? fontAwesomeIcons.filter(icon => icon.name.toLowerCase().includes(filter.toLowerCase()))
                : fontAwesomeIcons;

            filteredIcons.forEach(icon => {
                const iconDiv = document.createElement('div');
                iconDiv.className = 'col-2 text-center';
                iconDiv.innerHTML = `
                    <div class="icon-item p-3 border rounded cursor-pointer" 
                         data-icon-value="${icon.value}" 
                         style="cursor: pointer; transition: all 0.2s;"
                         onmouseover="this.style.backgroundColor='#f8f9fa'; this.style.transform='scale(1.05)';"
                         onmouseout="this.style.backgroundColor=''; this.style.transform='scale(1)';">
                        <i class="fas ${icon.class} fa-2x mb-2" style="display: inline-block;"></i>
                        <div class="small">${icon.name}</div>
                    </div>
                `;
                iconGrid.appendChild(iconDiv);
            });

            // Add click event to all icon items
            setTimeout(() => {
                document.querySelectorAll('.icon-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const iconValue = this.getAttribute('data-icon-value');
                        console.log('=== ICON SELECTED ===');
                        console.log('Icon value:', iconValue);
                        console.log('Target input ID:', currentTargetInput);
                        
                        if (currentTargetInput) {
                            const input = document.getElementById(currentTargetInput);
                            console.log('Input element found:', input ? 'YES' : 'NO');
                            
                            if (input) {
                                console.log('Input before update - value:', input.value);
                                console.log('Input before update - name:', input.name);
                                console.log('Input before update - readonly:', input.readOnly);
                                
                                // Remove readonly temporarily to ensure value is set
                                const wasReadonly = input.readOnly;
                                input.removeAttribute('readonly');
                                input.readOnly = false;
                                
                                // Set the value
                                input.value = iconValue;
                                
                                // Restore readonly
                                if (wasReadonly) {
                                    input.setAttribute('readonly', 'readonly');
                                    input.readOnly = true;
                                }
                                
                                console.log('Input after update - value:', input.value);
                                console.log('Input after update - readonly:', input.readOnly);
                                
                                // Trigger multiple events to ensure form recognizes the change
                                const changeEvent = new Event('change', { bubbles: true, cancelable: true });
                                const inputEvent = new Event('input', { bubbles: true, cancelable: true });
                                const blurEvent = new Event('blur', { bubbles: true, cancelable: true });
                                
                                input.dispatchEvent(changeEvent);
                                input.dispatchEvent(inputEvent);
                                input.dispatchEvent(blurEvent);
                                
                                // Also try setting via setAttribute
                                input.setAttribute('value', iconValue);
                                
                                // Visual feedback
                                input.style.backgroundColor = '#d4edda';
                                setTimeout(() => {
                                    input.style.backgroundColor = '';
                                }, 1000);
                                
                                // Final verification
                                console.log('Final input value:', input.value);
                                console.log('Final input getAttribute value:', input.getAttribute('value'));
                                
                                // Verify form will submit this value
                                const form = input.closest('form');
                                if (form) {
                                    const formData = new FormData(form);
                                    console.log('Form will submit icon value:', formData.get(input.name));
                                }
                            } else {
                                console.error('Input element not found with ID:', currentTargetInput);
                            }
                        } else {
                            console.error('No target input specified');
                        }
                        
                        if (modal) modal.hide();
                        console.log('=== ICON SELECTION END ===');
                    });
                });
            }, 100);
        }

        // Icon search
        if (iconSearch) {
            iconSearch.addEventListener('input', function() {
                renderIcons(this.value);
            });
        }

        // Open icon picker
        document.querySelectorAll('.icon-picker-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                currentTargetInput = this.getAttribute('data-target');
                if (!currentTargetInput) {
                    console.error('No target input specified');
                    return;
                }
                renderIcons();
                if (modal) {
                    modal.show();
                } else {
                    console.error('Modal not initialized');
                }
            });
        });

        // Reset search on modal close
        modalElement.addEventListener('hidden.bs.modal', function () {
            if (iconSearch) iconSearch.value = '';
        });
        
        // Also handle manual close
        modalElement.addEventListener('click', function(e) {
            if (e.target === modalElement || e.target.classList.contains('btn-close')) {
                if (iconSearch) iconSearch.value = '';
            }
        });
    }

    // Check if Font Awesome is loaded
    function checkFontAwesome() {
        const testIcon = document.createElement('i');
        testIcon.className = 'fas fa-user';
        testIcon.style.position = 'absolute';
        testIcon.style.visibility = 'hidden';
        document.body.appendChild(testIcon);
        const computed = window.getComputedStyle(testIcon, ':before');
        const fontFamily = computed.getPropertyValue('font-family');
        document.body.removeChild(testIcon);
        return fontFamily.includes('Font Awesome') || document.fonts.check('1em "Font Awesome 6 Free"');
    }

    // Wait for Font Awesome to load
    function waitForFontAwesome(callback, maxAttempts = 20) {
        let attempts = 0;
        const checkInterval = setInterval(() => {
            attempts++;
            if (checkFontAwesome() || attempts >= maxAttempts) {
                clearInterval(checkInterval);
                callback();
            }
        }, 100);
    }

    // Form submit handler to verify values and ensure readonly inputs submit
    const form = document.getElementById('drawerPageForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('=== FORM SUBMITTING ===');
            
            // Remove readonly from all icon inputs before submit to ensure they're submitted
            const iconInputs = document.querySelectorAll('input[name$="_icon"]');
            const readonlyStates = [];
            
            iconInputs.forEach((input, index) => {
                readonlyStates[index] = input.readOnly;
                input.removeAttribute('readonly');
                input.readOnly = false;
                console.log(`Icon field: ${input.name} = ${input.value} (readonly removed)`);
            });
            
            const formData = new FormData(form);
            
            // Log all icon values
            iconInputs.forEach((input, index) => {
                console.log(`Icon field: ${input.name} = ${input.value}`);
                console.log(`  - In FormData: ${formData.get(input.name)}`);
                
                // Restore readonly after logging
                if (readonlyStates[index]) {
                    input.setAttribute('readonly', 'readonly');
                    input.readOnly = true;
                }
            });
            
            // Verify all icon inputs have values
            let allIconsValid = true;
            iconInputs.forEach(input => {
                if (!input.value || input.value.trim() === '') {
                    console.error(`ERROR: Icon field ${input.name} is empty!`);
                    allIconsValid = false;
                }
            });
            
            if (!allIconsValid) {
                console.error('Some icon fields are empty! Form submission may fail.');
            }
            
            console.log('=== FORM SUBMIT END ===');
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            waitForFontAwesome(initIconPicker);
        });
    } else {
        // DOM already loaded
        waitForFontAwesome(initIconPicker);
    }
})();
</script>
@endsection
