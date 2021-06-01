<div class="row justify-content-center mt-5">
    <div class="col col-lg-4">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <img src="{{asset('images/uogbanner.jpeg')}}" class="w-100 mb-3" alt="...">
                <span>
                    <h4>
                        School of Engineering<hr>
                        COSHH Risk Assessment
                    </h4>
                </span>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="login">
                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <i class="fas fa-user"></i>
                        </div>
                        <label class="sr-only" for="guid">GUID</label>
                        <input id="guid" wire:model="guid" placeholder="GUID" class="form-control @error('guid') is-invalid @enderror" required autofocus autocomplete="off">
                        @error('guid')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-text"><i class="fas fa-key"></i></div>
                        <label class="sr-only" for="password">Password</label>
                        <input id="password" wire:model="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" required autocomplete="off">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="remember">Remember me</label>
                        <input type="checkbox" id="remember" name="remember" class="float-end">
                    </div>

                    @error('authentication')
                    <p class="text-danger font-weight-bold" style="font-size:80%">
                        <strong>{{ $message }}</strong>
                    </p>
                    @enderror

                    <button class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
