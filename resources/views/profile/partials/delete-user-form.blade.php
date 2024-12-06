<section class="tab-pane fade" id="delete-account-tab-pane" role="tabpanel" aria-labelledby="delete-account-tab" tabindex="0">
    <header class="pt-3">
        <h2>{{ __('Delete Account') }}</h2>
        <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>
    </header>
    <x-primary-button class="btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">{{ __('Delete Account') }}</x-primary-button>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteAccountModal">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}" >
                    <div class="modal-body">
                        @csrf
                        @method('delete')
                        <h2>{{ __('Are you sure you want to delete your account?') }}</h2>
                        <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}</p>
                        <div>
                            <x-input-label for="password" value="{{ __('Password') }}"  />
                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="{{ __('Password') }}"
                            />
                            <x-input-error :messages="$errors->userDeletion->get('password')"  />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <x-primary-button class="btn-danger">{{ __('Delete Account') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

