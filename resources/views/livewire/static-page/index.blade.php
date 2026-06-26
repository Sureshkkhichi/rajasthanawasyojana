<div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Pages</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0)">Frontend</a>
                                </li>
                                <li class="breadcrumb-item active">Pages</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($pages->isEmpty())
                <div class="alert alert-warning">
                    No pages found. Please run the database seeder to create default pages.
                </div>
            @else
                <form wire:submit.prevent="save">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <h4 class="card-title mb-0">Static Page Editor</h4>
                                    @if($selectedPageId)
                                        @php
                                            $selectedPage = $pages->firstWhere('id', $selectedPageId);
                                        @endphp
                                        @if($selectedPage)
                                            <a href="{{ url('/' . $selectedPage->slug) }}" target="_blank" class="btn btn-soft-primary btn-sm">
                                                <i class="ri-external-link-line align-bottom me-1"></i>
                                                Preview Page
                                            </a>
                                        @endif
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="row gy-4">
                                        <div class="col-md-4">
                                            <label class="form-label">Page</label>
                                            <select class="form-select rounded-pill @error('selectedPageId') is-invalid @enderror" wire:model.live="selectedPageId">
                                                @foreach($pages as $pageOption)
                                                    <option value="{{ $pageOption->id }}">{{ $pageOption->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('selectedPageId')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-5">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control rounded-pill @error('title') is-invalid @enderror" wire:model="title">
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select rounded-pill @error('status') is-invalid @enderror" wire:model="status">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Content Editor</label>
                                            <div wire:ignore id="page-content-editor-wrapper">
                                                <textarea id="page-content-editor" class="form-control">{!! $content !!}</textarea>
                                            </div>
                                            @error('content')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    @can('pages.edit')
                                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                            <i class="ri-save-line align-bottom me-1"></i>
                                            Save Page
                                        </button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            .ck-editor__editable {
                min-height: 420px;
            }
        </style>
    @endpush

    @once
        @push('scripts')
            <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
            <script>
                (function () {
                    if (window.__staticPageEditorBootstrapped) {
                        return;
                    }

                    window.__staticPageEditorBootstrapped = true;

                    let pageContentEditor = null;
                    let editorInitPromise = null;

                    function getEditorElement() {
                        return document.querySelector('#page-content-editor');
                    }

                    function ensurePageContentEditor() {
                        if (pageContentEditor) {
                            return Promise.resolve(pageContentEditor);
                        }

                        if (editorInitPromise) {
                            return editorInitPromise;
                        }

                        const element = getEditorElement();

                        if (!element) {
                            return Promise.resolve(null);
                        }

                        editorInitPromise = ClassicEditor.create(element, {
                            toolbar: [
                                'heading', '|',
                                'bold', 'italic', 'underline', 'link', '|',
                                'bulletedList', 'numberedList', '|',
                                'blockQuote', 'insertTable', '|',
                                'undo', 'redo'
                            ],
                        }).then(editor => {
                            pageContentEditor = editor;

                            editor.model.document.on('change:data', () => {
                                const componentEl = document.querySelector('#page-content-editor-wrapper')?.closest('[wire\\:id]');

                                if (!componentEl) {
                                    return;
                                }

                                const component = window.Livewire.find(componentEl.getAttribute('wire:id'));

                                if (component) {
                                    component.set('content', editor.getData());
                                }
                            });

                            return editor;
                        }).catch(error => {
                            editorInitPromise = null;
                            console.error(error);
                            return null;
                        });

                        return editorInitPromise;
                    }

                    function setPageContent(content) {
                        ensurePageContentEditor().then(editor => {
                            if (editor) {
                                editor.setData(content || '');
                            }
                        });
                    }

                    document.addEventListener('livewire:init', () => {
                        Livewire.on('editor-set-content', ({ content }) => {
                            setPageContent(content);
                        });

                        ensurePageContentEditor().then(editor => {
                            if (!editor) {
                                return;
                            }

                            const element = getEditorElement();

                            if (element && element.value && !editor.getData()) {
                                editor.setData(element.value);
                            }
                        });
                    });
                })();
            </script>
        @endpush
    @endonce
</div>
