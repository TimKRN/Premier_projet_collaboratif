{extends file="views/structure.tpl"}

{block name="content"}
    <main>
        <div class="gallery-container">
            <div class="gallery-item" data-index="1">
                <img src="assets/img/imageGalerie1.jpg" alt="Photo de chat">
            </div>
            <div class="gallery-item" data-index="2">
                <img src="assets/img/imageGalerie2.jpg" alt="Photo de chat">
            </div>
            <div class="gallery-item" data-index="3">
                <img src="assets/img/imageGalerie3.jpg" alt="Photo de chat">
            </div>
            <div class="gallery-item" data-index="4">
                <img src="assets/img/imageGalerie4.jpg" alt="Photo de chat">
            </div>
            <div class="gallery-item" data-index="5">
                <img src="assets/img/imageGalerie5.jpg" alt="Photo de chat">
            </div>
            <div class="gallery-item" data-index="6">
                <img src="assets/img/imageGalerie6.jpg" alt="Photo de chat">
            </div>
        </div>
    </main>
{/block}

{block name="JS" append}
    <script src="assets/scripts/script.js"></script>
{/block}