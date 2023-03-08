    <div id="blocFA" class="col-md-2 mx-5 my-3 py-3 mx-3">
        <div class="text-center">
            <a href="index.php?ctrl=user&action=vueProfil&id={$arrDetResultPetsitter['user_id']}" ><img src="assets/img/icon/iconPS.png" alt=""></a>
        </div>
        <div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Ville: <span>{$arrDetResultPetsitter['city_name']}</span></li>
                <li class="list-group-item">Prénom: <span>{$arrDetResultPetsitter['user_firstname']}</span></li>
                <li class="list-group-item">Age: <span>{$arrDetResultPetsitter['user_birthday']|date_format:"d/m/Y"}</span></li>
                <li class="list-group-item">Type de logement:<span>{$arrDetResultPetsitter['home_type']}</span></li>
                <li class="list-group-item text-center">&#x2605; &#x2605; &#x2605; &#x2605; &#x2605;
                </li>
            </ul>
        </div>
    </div>
                
    