<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vytvořit školu
        </h2>
    </x-slot>

    <div class="py-12">
        <x-dashboard-card>
            <form wire:submit.prevent="submit">
                <div class="form-row-2">
                    <div class="form-field">
                        <label for="name" class="label">Název školy</label>
                        <input id="name" type="text" wire:model="name"
                               class="input @error('name') input-error @enderror">
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-field">
                        <label for="address" class="label">Ulice a č.p.</label>
                        <input id="address" type="text" wire:model="address"
                               class="input @error('address') input-error @enderror">
                        @error('address') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row-2">
                    <div class="form-field">
                        <label for="psc" class="label">PSČ</label>
                        <input id="psc" type="text" wire:model="psc" class="input @error('psc') input-error @enderror">
                        @error('psc') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-field">
                        <label for="city" class="label">Město</label>
                        <input id="city" type="text" wire:model="city"
                               class="input @error('city') input-error @enderror">
                        @error('city') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row-2">
                    <div class="form-field">
                        <label for="ico" class="label">IČ</label>
                        <input id="ico" type="text" wire:model="ico" class="input @error('ico') input-error @enderror">
                        @error('ico') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-field">
                        <label for="izo" class="label">IZO</label>
                        <input id="izo" type="text" wire:model="izo" class="input @error('izo') input-error @enderror">
                        @error('izo') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row-2">
                    <div class="form-field">
                        <label for="email" class="label">Emailová adresa</label>
                        <input id="email" type="text" wire:model="email"
                               class="input @error('email') input-error @enderror">
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-field">
                        <label for="web" class="label">Adresa webu</label>
                        <input id="web" type="text" wire:model="web" class="input @error('web') input-error @enderror">
                        @error('web') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row-2">
                    <div>
                        <label for="phone" class="label">Telefon</label>
                        <input id="phone" type="text" wire:model="phone"
                               class="input @error('phone') input-error @enderror">
                        @error('phone') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="district_id" class="label">Okres</label>
                        <select name="district" id="district_id" wire:model="district_id"
                                class="input @error('address') input-error @enderror">
                            <option value="" selected></option>
                            @foreach($districts as $district)
                                <option value="{{$district->id}}">{{$district->name}}</option>
                            @endforeach
                        </select>
                        @error('district_id') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <label for="logo" class="label">Logo</label>
                    <input type="file" wire:model="logo" id="logo" class="input">
                    @error('logo') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-row">
                    <div wire:ignore>
                        <label for="description">Text o škole (je možné využít html značek k formátování)</label>
                        <textarea name="description" id="description" cols="30" rows="10"
                                  class="input @error('address') input-error @enderror"></textarea>
                    </div>
                    @error('description') <span class="error">{{ $message }}</span> @enderror
                </div>


                <div class="form-row">
                    <button type="submit" class="btn btn-primary">Vytvořit</button>
                </div>
            </form>
        </x-dashboard-card>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.4.2/tinymce.min.js"
                integrity="sha512-SPCExIkjTrrcv8Jfu4dzvDJfMe7A9CKmKE8v1fd+Ku3Dq5B9w8rfmrAHfz2RKU+4zOyT1JlprGA1bC2o8Z1yZA=="
                crossorigin="anonymous"></script>
        <script>
            document.addEventListener('livewire:load', function () {
                // sorry just livewire fuckery
                const lw = @this;

                tinymce.init({
                    selector: 'textarea#description',
                    menubar: false,
                    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code removeformat | image',
                    plugins: [
                        'image', 'imagetools', 'table', 'paste', 'wordcount', 'code', 'lists', 'advlist',
                    ],
                    advlist_bullet_styles: 'square',
                    advlist_number_styles: 'lower-alpha,lower-roman,upper-alpha,upper-roman',
                    enable_caption: true,
                    images_upload_handler: function (blobInfo, success, failure, progress) {
                        var xhr, formData;

                        xhr = new XMLHttpRequest();
                        xhr.withCredentials = true;
                        xhr.open('POST', '/obrazek/nahrat');

                        xhr.upload.onprogress = function (e) {
                            progress(e.loaded / e.total * 100);
                        };

                        xhr.onload = function () {
                            var json;

                            if (xhr.status < 200 || xhr.status >= 300) {
                                failure("Chyba nahrávání: " + xhr.responseText);
                                return;
                            }

                            json = JSON.parse(xhr.responseText);

                            if (!json || typeof json.location != 'string') {
                                return failure("Chyba nahrávání");
                            }

                            success(json.location);
                        };

                        xhr.onerror = function () {
                            failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                        };

                        formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());

                        xhr.send(formData);
                    },
                    image_list: [
                            @foreach(Auth::user()->images()->get() as $image)
                        {
                            title: "Nahraný obrázek č. {{$loop->index}}",
                            value: "/storage/{{$image->name}}"
                        },
                        @endforeach
                    ],
                    init_instance_callback: editor => {
                        if (lw.get("description")) {
                            editor.setContent(lw.get("description"))
                        }

                        editor.on("nodechange", () => {
                            lw.description = tinymce.activeEditor.getContent()
                        })
                    },

                });
            })
        </script>
    </div>
</div>
