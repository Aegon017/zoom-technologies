<div>
    <style>
        .error-message {
            position: fixed;
            top: 13%;
            right: 2%;
            z-index: 100;
        }

        h1 {
            margin-bottom: 1.5rem;
            color: #fd5222;
            font-weight: 600;
            font-size: 2rem;
        }

        p {
            margin-bottom: 2rem;
            color: gray;
            font-weight: 300;
        }

        .otp-input {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .otp-input input {
            width: 50px;
            height: 50px;
            margin: 0 8px;
            text-align: center;
            font-size: 1.5rem;
            border: 2px solid gray;
            border-radius: 12px;
            background-color: #e8e8e8;
            color: #666666;
            transition: all 0.3s ease;
        }

        .otp-input input:focus {
            border-color: #fd5222;
            box-shadow: 0 0 0 2px rgba(166, 86, 246, 0.3);
            outline: none;
        }

        .otp-input input::-webkit-outer-spin-button,
        .otp-input input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .otp-input input[type=number] {
            -moz-appearance: textfield;
        }

        button {
            background: #fd5222;
            color: white;
            border: 2px solid #fd5222;
            padding: 8px 32px;
            font-size: 1rem;
            border-radius: 8px;
            cursor: pointer;
            margin: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        button:hover {
            background: #ff4444;
            transform: translateY(-2px);
        }

        button:disabled {
            background: #cccccc;
            border-color: #999999;
            color: #666666;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        #timer {
            font-size: 1rem;
            color: #fd5222;
            font-weight: 500;
            margin-left: 10px;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        .expired {
            animation: pulse 2s infinite;
            color: #ff4444;
        }

        .resend-text {
            margin-top: 1rem;
            font-size: 0.9rem;
            color: gray;
        }

        .resend-link {
            color: #fd5222;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .resend-link:hover {
            color: #ff4444;
            text-decoration: underline;
        }

        #email {
            color: #fd5222;
            font-weight: 500;
        }
    </style>
    @if ($successMessage)
        <div class="alert alert-success alert-dismissible fade show error-message" role="alert">
            <strong>{{ $successMessage }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @guest
        <h6>Contact Information</h6>
        <div class="mb-3 position-relative">
            <label for="checkout-name" class="form-label">Full Name *</label>
            <div class="input-group">
                <span class="input-group-text rounded-0"><i class="fa fa-user-circle"></i></span>
                <input wire:model.live="fullName" type="text" class="form-control" id="checkout-name" name="fullName"
                    placeholder="Enter your name..." required>
            </div>
        </div>

        <div class="mb-3 position-relative">
            <label for="checkout-email" class="form-label">E-mail *</label>
            <div class="input-group">
                <span class="input-group-text rounded-0"><i class="fa fa-envelope"></i></span>
                <input wire:model.live="email" type="email" class="form-control" id="checkout-email" name="email"
                    placeholder="Enter your email..." required>
            </div>
        </div>

        <div class="mb-3 position-relative">
            <label for="checkout-phone" class="form-label">Phone (Optional)</label>
            <div class="input-group">
                <span class="input-group-text rounded-0"><i class="fa fa-phone"></i></span>
                <x-input wire:model.live="phone" id="phone_number" class="block w-ful form-control" type="tel"
                    name="phone_number" autocomplete="phone_number" placeholder="Enter phone number" />
                <input type="hidden" name="phone" id="phone" />
            </div>
        </div>
        <br>
    @endguest
    @if (Auth::user() && Auth::user()->addresses)
        <h6>Shipping Address</h6>
        <div class="mb-3 position-relative">
            <label for="checkout-address" class="form-label">Address *</label>
            <div class="input-group">
                <span class="input-group-text rounded-0"><i class="fa fa-home"></i></span>
                <input type="text" wire:model.live="fAddress" class="form-control" name="address" id="address"
                    placeholder="Your address..." required>
            </div>
        </div>

        <div class="mb-3 position-relative">
            <label for="checkout-city" class="form-label">City *</label>
            <div class="input-group">
                <span class="input-group-text rounded-0"><i class="fa fa-building"></i></span>
                <input type="text" wire:model.live="city" class="form-control" name="city" id="checkout-city"
                    placeholder="Your city..." required>
            </div>
        </div>

        <div class="mb-3 position-relative">
            <label for="checkout-state" class="form-label">State *</label>
            <div class="input-group">
                <span class="input-group-text rounded-0"><i class="fa fa-building"></i></span>
                <input type="text" wire:model.live="state" class="form-control" name="state" id="checkout-state"
                    placeholder="Your state..." required>
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col">
                <label for="checkout-country" class="form-label">Country *</label>
                <div class="input-group">
                    <span class="input-group-text rounded-0"><i class="fa fa-globe"></i></span>
                    <input type="text" wire:model.live="country" class="form-control" name="country"
                        id="checkout-country" placeholder="Your country..." list="country-list" required>
                    <datalist id="country-list">
                        <option value="Afghanistan"></option>
                        <option value="Albania"></option>
                        <option value="Algeria"></option>
                        <option value="Andorra"></option>
                        <option value="Angola"></option>
                        <option value="Antigua and Barbuda"></option>
                        <option value="Argentina"></option>
                        <option value="Armenia"></option>
                        <option value="Australia"></option>
                        <option value="Austria"></option>
                        <option value="Azerbaijan"></option>
                        <option value="Bahamas"></option>
                        <option value="Bahrain"></option>
                        <option value="Bangladesh"></option>
                        <option value="Barbados"></option>
                        <option value="Belarus"></option>
                        <option value="Belgium"></option>
                        <option value="Belize"></option>
                        <option value="Benin"></option>
                        <option value="Bhutan"></option>
                        <option value="Bolivia"></option>
                        <option value="Bosnia and Herzegovina"></option>
                        <option value="Botswana"></option>
                        <option value="Brazil"></option>
                        <option value="Brunei Darussalam"></option>
                        <option value="Bulgaria"></option>
                        <option value="Burkina Faso"></option>
                        <option value="Burundi"></option>
                        <option value="Cabo Verde"></option>
                        <option value="Cambodia"></option>
                        <option value="Cameroon"></option>
                        <option value="Canada"></option>
                        <option value="Central African Republic"></option>
                        <option value="Chad"></option>
                        <option value="Chile"></option>
                        <option value="China"></option>
                        <option value="Colombia"></option>
                        <option value="Comoros"></option>
                        <option value="Congo (Congo-Brazzaville)"></option>
                        <option value="Congo (Congo-Kinshasa)"></option>
                        <option value="Costa Rica"></option>
                        <option value="Croatia"></option>
                        <option value="Cuba"></option>
                        <option value="Cyprus"></option>
                        <option value="Czech Republic"></option>
                        <option value="Denmark"></option>
                        <option value="Djibouti"></option>
                        <option value="Dominica"></option>
                        <option value="Dominican Republic"></option>
                        <option value="Ecuador"></option>
                        <option value="Egypt"></option>
                        <option value="El Salvador"></option>
                        <option value="Equatorial Guinea"></option>
                        <option value="Eritrea"></option>
                        <option value="Estonia"></option>
                        <option value="Eswatini"></option>
                        <option value="Ethiopia"></option>
                        <option value="Fiji"></option>
                        <option value="Finland"></option>
                        <option value="France"></option>
                        <option value="Gabon"></option>
                        <option value="Gambia"></option>
                        <option value="Georgia"></option>
                        <option value="Germany"></option>
                        <option value="Ghana"></option>
                        <option value="Greece"></option>
                        <option value="Grenada"></option>
                        <option value="Guatemala"></option>
                        <option value="Guinea"></option>
                        <option value="Guinea-Bissau"></option>
                        <option value="Guyana"></option>
                        <option value="Haiti"></option>
                        <option value="Honduras"></option>
                        <option value="Hungary"></option>
                        <option value="Iceland"></option>
                        <option value="India"></option>
                        <option value="Indonesia"></option>
                        <option value="Iran"></option>
                        <option value="Iraq"></option>
                        <option value="Ireland"></option>
                        <option value="Israel"></option>
                        <option value="Italy"></option>
                        <option value="Jamaica"></option>
                        <option value="Japan"></option>
                        <option value="Jordan"></option>
                        <option value="Kazakhstan"></option>
                        <option value="Kenya"></option>
                        <option value="Kiribati"></option>
                        <option value="Korea, North"></option>
                        <option value="Korea, South"></option>
                        <option value="Kuwait"></option>
                        <option value="Kyrgyzstan"></option>
                        <option value="Laos"></option>
                        <option value="Latvia"></option>
                        <option value="Lebanon"></option>
                        <option value="Lesotho"></option>
                        <option value="Liberia"></option>
                        <option value="Libya"></option>
                        <option value="Liechtenstein"></option>
                        <option value="Lithuania"></option>
                        <option value="Luxembourg"></option>
                        <option value="Madagascar"></option>
                        <option value="Malawi"></option>
                        <option value="Malaysia"></option>
                        <option value="Maldives"></option>
                        <option value="Mali"></option>
                        <option value="Malta"></option>
                        <option value="Marshall Islands"></option>
                        <option value="Mauritania"></option>
                        <option value="Mauritius"></option>
                        <option value="Mexico"></option>
                        <option value="Micronesia"></option>
                        <option value="Moldova"></option>
                        <option value="Monaco"></option>
                        <option value="Mongolia"></option>
                        <option value="Montenegro"></option>
                        <option value="Morocco"></option>
                        <option value="Mozambique"></option>
                        <option value="Myanmar"></option>
                        <option value="Namibia"></option>
                        <option value="Nauru"></option>
                        <option value="Nepal"></option>
                        <option value="Netherlands"></option>
                        <option value="New Zealand"></option>
                        <option value="Nicaragua"></option>
                        <option value="Niger"></option>
                        <option value="Nigeria"></option>
                        <option value="North Macedonia"></option>
                        <option value="Norway"></option>
                        <option value="Oman"></option>
                        <option value="Pakistan"></option>
                        <option value="Palau"></option>
                        <option value="Panama"></option>
                        <option value="Papua New Guinea"></option>
                        <option value="Paraguay"></option>
                        <option value="Peru"></option>
                        <option value="Philippines"></option>
                        <option value="Poland"></option>
                        <option value="Portugal"></option>
                        <option value="Qatar"></option>
                        <option value="Romania"></option>
                        <option value="Russia"></option>
                        <option value="Rwanda"></option>
                        <option value="Saint Kitts and Nevis"></option>
                        <option value="Saint Lucia"></option>
                        <option value="Saint Vincent and the Grenadines"></option>
                        <option value="Samoa"></option>
                        <option value="San Marino"></option>
                        <option value="Sao Tome and Principe"></option>
                        <option value="Saudi Arabia"></option>
                        <option value="Senegal"></option>
                        <option value="Serbia"></option>
                        <option value="Seychelles"></option>
                        <option value="Sierra Leone"></option>
                        <option value="Singapore"></option>
                        <option value="Slovakia"></option>
                        <option value="Slovenia"></option>
                        <option value="Solomon Islands"></option>
                        <option value="Somalia"></option>
                        <option value="South Africa"></option>
                        <option value="South Sudan"></option>
                        <option value="Spain"></option>
                        <option value="Sri Lanka"></option>
                        <option value="Sudan"></option>
                        <option value="Suriname"></option>
                        <option value="Sweden"></option>
                        <option value="Switzerland"></option>
                        <option value="Syria"></option>
                        <option value="Taiwan"></option>
                        <option value="Tajikistan"></option>
                        <option value="Tanzania"></option>
                        <option value="Thailand"></option>
                        <option value="Timor-Leste"></option>
                        <option value="Togo"></option>
                        <option value="Tonga"></option>
                        <option value="Trinidad and Tobago"></option>
                        <option value="Tunisia"></option>
                        <option value="Turkey"></option>
                        <option value="Turkmenistan"></option>
                        <option value="Tuvalu"></option>
                        <option value="Uganda"></option>
                        <option value="Ukraine"></option>
                        <option value="United Arab Emirates"></option>
                        <option value="United Kingdom"></option>
                        <option value="United States"></option>
                        <option value="Uruguay"></option>
                        <option value="Uzbekistan"></option>
                        <option value="Vanuatu"></option>
                        <option value="Vatican City"></option>
                        <option value="Venezuela"></option>
                        <option value="Vietnam"></option>
                        <option value="Yemen"></option>
                        <option value="Zambia"></option>
                        <option value="Zimbabwe"></option>
                    </datalist>
                </div>
            </div>
            <div class="col">
                <label for="checkout-postal" class="form-label">Zip Code *</label>
                <div class="input-group">
                    <span class="input-group-text rounded-0"><i class="fa fa-archive"></i></span>
                    <input type="text" wire:model.live="zipCode" class="form-control" name="zip_code"
                        id="checkout-postal" placeholder="Your postal code..." required>
                </div>
            </div>
        </div>
        @if ($isFormValid)
            <div class="text-right pb-5">
                <button wire:click.prevent="addressUpdate" type="submit" class="continue-btn">
                    Update
                </button>
            </div>
        @endif
    @else
        <div class="mb-3 position-relative">
            <label for="checkout-address" class="form-label">Address *</label>
            <div class="input-group">
                <span class="input-group-text rounded-0"><i class="fa fa-home"></i></span>
                <input type="text" wire:model.live="fAddress" class="form-control" name="address" id="address"
                    placeholder="Your address..." required>
            </div>
        </div>

        <div class="mb-3 position-relative">
            <label for="checkout-city" class="form-label">City *</label>
            <div class="input-group">
                <span class="input-group-text rounded-0"><i class="fa fa-building"></i></span>
                <input type="text" wire:model.live="city" class="form-control" name="city" id="checkout-city"
                    placeholder="Your city..." required>
            </div>
        </div>

        <div class="mb-3 position-relative">
            <label for="checkout-state" class="form-label">State *</label>
            <div class="input-group">
                <span class="input-group-text rounded-0"><i class="fa fa-building"></i></span>
                <input type="text" wire:model.live="state" class="form-control" name="state"
                    id="checkout-state" placeholder="Your state..." required>
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col">
                <label for="checkout-country" class="form-label">Country *</label>
                <div class="input-group">
                    <span class="input-group-text rounded-0"><i class="fa fa-globe"></i></span>
                    <input type="text" wire:model.live="country" class="form-control" name="country"
                        id="checkout-country" placeholder="Your country..." list="country-list" required>
                    <datalist id="country-list">
                        <option value="Afghanistan"></option>
                        <option value="Albania"></option>
                        <option value="Algeria"></option>
                        <option value="Andorra"></option>
                        <option value="Angola"></option>
                        <option value="Antigua and Barbuda"></option>
                        <option value="Argentina"></option>
                        <option value="Armenia"></option>
                        <option value="Australia"></option>
                        <option value="Austria"></option>
                        <option value="Azerbaijan"></option>
                        <option value="Bahamas"></option>
                        <option value="Bahrain"></option>
                        <option value="Bangladesh"></option>
                        <option value="Barbados"></option>
                        <option value="Belarus"></option>
                        <option value="Belgium"></option>
                        <option value="Belize"></option>
                        <option value="Benin"></option>
                        <option value="Bhutan"></option>
                        <option value="Bolivia"></option>
                        <option value="Bosnia and Herzegovina"></option>
                        <option value="Botswana"></option>
                        <option value="Brazil"></option>
                        <option value="Brunei Darussalam"></option>
                        <option value="Bulgaria"></option>
                        <option value="Burkina Faso"></option>
                        <option value="Burundi"></option>
                        <option value="Cabo Verde"></option>
                        <option value="Cambodia"></option>
                        <option value="Cameroon"></option>
                        <option value="Canada"></option>
                        <option value="Central African Republic"></option>
                        <option value="Chad"></option>
                        <option value="Chile"></option>
                        <option value="China"></option>
                        <option value="Colombia"></option>
                        <option value="Comoros"></option>
                        <option value="Congo (Congo-Brazzaville)"></option>
                        <option value="Congo (Congo-Kinshasa)"></option>
                        <option value="Costa Rica"></option>
                        <option value="Croatia"></option>
                        <option value="Cuba"></option>
                        <option value="Cyprus"></option>
                        <option value="Czech Republic"></option>
                        <option value="Denmark"></option>
                        <option value="Djibouti"></option>
                        <option value="Dominica"></option>
                        <option value="Dominican Republic"></option>
                        <option value="Ecuador"></option>
                        <option value="Egypt"></option>
                        <option value="El Salvador"></option>
                        <option value="Equatorial Guinea"></option>
                        <option value="Eritrea"></option>
                        <option value="Estonia"></option>
                        <option value="Eswatini"></option>
                        <option value="Ethiopia"></option>
                        <option value="Fiji"></option>
                        <option value="Finland"></option>
                        <option value="France"></option>
                        <option value="Gabon"></option>
                        <option value="Gambia"></option>
                        <option value="Georgia"></option>
                        <option value="Germany"></option>
                        <option value="Ghana"></option>
                        <option value="Greece"></option>
                        <option value="Grenada"></option>
                        <option value="Guatemala"></option>
                        <option value="Guinea"></option>
                        <option value="Guinea-Bissau"></option>
                        <option value="Guyana"></option>
                        <option value="Haiti"></option>
                        <option value="Honduras"></option>
                        <option value="Hungary"></option>
                        <option value="Iceland"></option>
                        <option value="India"></option>
                        <option value="Indonesia"></option>
                        <option value="Iran"></option>
                        <option value="Iraq"></option>
                        <option value="Ireland"></option>
                        <option value="Israel"></option>
                        <option value="Italy"></option>
                        <option value="Jamaica"></option>
                        <option value="Japan"></option>
                        <option value="Jordan"></option>
                        <option value="Kazakhstan"></option>
                        <option value="Kenya"></option>
                        <option value="Kiribati"></option>
                        <option value="Korea, North"></option>
                        <option value="Korea, South"></option>
                        <option value="Kuwait"></option>
                        <option value="Kyrgyzstan"></option>
                        <option value="Laos"></option>
                        <option value="Latvia"></option>
                        <option value="Lebanon"></option>
                        <option value="Lesotho"></option>
                        <option value="Liberia"></option>
                        <option value="Libya"></option>
                        <option value="Liechtenstein"></option>
                        <option value="Lithuania"></option>
                        <option value="Luxembourg"></option>
                        <option value="Madagascar"></option>
                        <option value="Malawi"></option>
                        <option value="Malaysia"></option>
                        <option value="Maldives"></option>
                        <option value="Mali"></option>
                        <option value="Malta"></option>
                        <option value="Marshall Islands"></option>
                        <option value="Mauritania"></option>
                        <option value="Mauritius"></option>
                        <option value="Mexico"></option>
                        <option value="Micronesia"></option>
                        <option value="Moldova"></option>
                        <option value="Monaco"></option>
                        <option value="Mongolia"></option>
                        <option value="Montenegro"></option>
                        <option value="Morocco"></option>
                        <option value="Mozambique"></option>
                        <option value="Myanmar"></option>
                        <option value="Namibia"></option>
                        <option value="Nauru"></option>
                        <option value="Nepal"></option>
                        <option value="Netherlands"></option>
                        <option value="New Zealand"></option>
                        <option value="Nicaragua"></option>
                        <option value="Niger"></option>
                        <option value="Nigeria"></option>
                        <option value="North Macedonia"></option>
                        <option value="Norway"></option>
                        <option value="Oman"></option>
                        <option value="Pakistan"></option>
                        <option value="Palau"></option>
                        <option value="Panama"></option>
                        <option value="Papua New Guinea"></option>
                        <option value="Paraguay"></option>
                        <option value="Peru"></option>
                        <option value="Philippines"></option>
                        <option value="Poland"></option>
                        <option value="Portugal"></option>
                        <option value="Qatar"></option>
                        <option value="Romania"></option>
                        <option value="Russia"></option>
                        <option value="Rwanda"></option>
                        <option value="Saint Kitts and Nevis"></option>
                        <option value="Saint Lucia"></option>
                        <option value="Saint Vincent and the Grenadines"></option>
                        <option value="Samoa"></option>
                        <option value="San Marino"></option>
                        <option value="Sao Tome and Principe"></option>
                        <option value="Saudi Arabia"></option>
                        <option value="Senegal"></option>
                        <option value="Serbia"></option>
                        <option value="Seychelles"></option>
                        <option value="Sierra Leone"></option>
                        <option value="Singapore"></option>
                        <option value="Slovakia"></option>
                        <option value="Slovenia"></option>
                        <option value="Solomon Islands"></option>
                        <option value="Somalia"></option>
                        <option value="South Africa"></option>
                        <option value="South Sudan"></option>
                        <option value="Spain"></option>
                        <option value="Sri Lanka"></option>
                        <option value="Sudan"></option>
                        <option value="Suriname"></option>
                        <option value="Sweden"></option>
                        <option value="Switzerland"></option>
                        <option value="Syria"></option>
                        <option value="Taiwan"></option>
                        <option value="Tajikistan"></option>
                        <option value="Tanzania"></option>
                        <option value="Thailand"></option>
                        <option value="Timor-Leste"></option>
                        <option value="Togo"></option>
                        <option value="Tonga"></option>
                        <option value="Trinidad and Tobago"></option>
                        <option value="Tunisia"></option>
                        <option value="Turkey"></option>
                        <option value="Turkmenistan"></option>
                        <option value="Tuvalu"></option>
                        <option value="Uganda"></option>
                        <option value="Ukraine"></option>
                        <option value="United Arab Emirates"></option>
                        <option value="United Kingdom"></option>
                        <option value="United States"></option>
                        <option value="Uruguay"></option>
                        <option value="Uzbekistan"></option>
                        <option value="Vanuatu"></option>
                        <option value="Vatican City"></option>
                        <option value="Venezuela"></option>
                        <option value="Vietnam"></option>
                        <option value="Yemen"></option>
                        <option value="Zambia"></option>
                        <option value="Zimbabwe"></option>
                    </datalist>
                </div>
            </div>
            <div class="col">
                <label for="checkout-postal" class="form-label">Zip Code *</label>
                <div class="input-group">
                    <span class="input-group-text rounded-0"><i class="fa fa-archive"></i></span>
                    <input type="text" wire:model.live="zipCode" class="form-control" name="zip_code"
                        id="checkout-postal" placeholder="Your postal code..." required>
                </div>
            </div>
        </div>
        @if ($isFormValid)
            <div class="text-right pb-5">
                <button wire:click.prevent="register" type="submit" class="continue-btn">
                    Create
                </button>
            </div>
        @endif
    @endif

    @if ($errorMessage)
        <div class="alert alert-danger alert-dismissible fade show error-message" role="alert">
            <strong>{{ $errorMessage }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <livewire:otp-verification />
</div>
