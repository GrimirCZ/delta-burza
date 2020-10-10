{{-- You can change this template using File > Settings > Editor > File and Code Templates > Code > Laravel Ideal Blade View Component --}}
<div>
    <div>
        <div wire:ignore>
            <label for="{{$field}}" class="mb-2 label inline-block">{{$label}}</label>

            <textarea name="{{$field}}" id="{{$field}}" cols="30" rows="10"
                      class="input @error($field) input-error @enderror"></textarea>
        </div>
        @error($field) <span class="error">{{ $message }}</span> @enderror
    </div>
    @push('scripts')
        @once
        <script src="{{asset("tinymce/tinymce.min.js")}}" defer></script>
        @endonce
        <script>
            document.addEventListener('livewire:load', function () {
                // sorry just livewire fuckery
                const lw = @this;

                tinymce.init({
                    selector: 'textarea#{{$field}}',
                    menubar: false,
                    toolbar: 'undo redo | formatselect | bold italic underline link | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code removeformat | image',
                    plugins: [
                        'image', 'imagetools', 'table', 'paste', 'wordcount', 'code', 'lists', 'advlist', 'link'
                    ],
                    advlist_bullet_styles: 'square',
                    advlist_number_styles: 'lower-alpha,lower-roman,upper-alpha,upper-roman',
                    enable_caption: true,
                    language: 'cs',
                    extended_valid_elements: 'a[href|target|target=_blank]',
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
                            @foreach($images as $image)
                        {
                            title: "Nahraný obrázek č. {{$loop->index}}",
                            value: "{{$image->name}}"
                        },
                        @endforeach
                    ],
                    init_instance_callback: editor => {
                        if (lw.get("{{$field}}")) {
                            editor.setContent(lw.get("{{$field}}"))
                        }

                        editor.on("nodechange", () => {
                            lw.{{$field}} = tinymce.activeEditor.getContent()
                        })
                    },

                });
            })
        </script>
    @endpush
</div>
