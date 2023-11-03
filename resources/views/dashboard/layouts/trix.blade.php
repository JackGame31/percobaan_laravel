{{-- link untuk menggunakan trix --}}
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

{{-- menghilangkan display trix upload file --}}
<style>
    trix-toolbar [data-trix-button-group="file-tools"] {
        display: none;
    }
</style>