##### [![SmartGaP](http://tst.smartgap.it/admin/templates/SmartGaP_new/images/logo.png)](http://www.smartgap.it)

# esyFileManager 
______________

**Versione 1.0**

È un filemanager openSource scritto in PHP e jQuery che lavora direttamente sul filesystem senza l'ausilio di un database.

EsyFileManager non necessita di installazioni particolari sul server ed è semplicissimo da installare

È possibile utilizzare esyfilemanager per selezionare file all'interno di un campo di input.

EsyFileManager può essere usato come plugin per editor di testi WysWyg come cKeditor

**[GUARDA LA DEMO](http://esyfilemanager.smartgap.it)**

Il software è rilasciato con le licenze open source [GPL](http://www.gnu.org/licenses/gpl-2.0.txt) e [LGPL](http://www.gnu.org/licenses/lgpl-3.0.txt)

______________

#### EsyFileManager utilizza le seguenti librerie OpenSource:

* file-uploader | <https://github.com/valums/file-uploader>
* jQuery URL Parser | <https://github.com/allmarkedup/jQuery-URL-Parser>
* jQuery | <http://jquery.com/>
* jQuery ui | <http://jqueryui.com/>

#### File Icons

* <http://www.fatcow.com/free-icons>

#### Testato su

* IE8
* IE9
* Chrome
* Safari
* Firefox

_______________

#### Istruzioni

Includere la cartella esyFileManager ed il file js/popup.functions.js nel proprio progetto

**Include**

Includere jQuery ed il file popup.functions.js nel proprio progetto

```
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="js/popup.functions.js"></script>
```

**Installazione standalone**

Creare un bottone

```
<button class="standalone">Apri filemanger</button>
```

Inserire il codice per lanciare il filemanager

```
$(".standalone").click(function(){
	popStandalone();
});
```
**Installazione su input field**

Creare un campo input per un file

```
<input type="text" id="file" name="file" >
```

Aggiungere il codice per lanciare il filemanager specificando l'id del campo di testo

```
$("#file").click(function(){
	popFile("file");
});
```

**Installazione in cKeditor**

Installare cKeditor seguendo le istruzioni del produttore <http://ckeditor.com>

editare il file config.js in cKeditor ed aggiungere la seguente stringa

```
config.filebrowserBrowseUrl = 'path/to/esyFileManager/index.php?u=2';
```

**Installazione in tinyMCE**

Installare tinyMCE seguendo le istruzioni del produttore <http://www.tinymce.com>

aggiungere la seguente stringa nella funzione tinyMCE.init

```
file_browser_callback : "esyFileManage"
```

ed includere il file tinyMCE_connect.js

```
<script src="js/tinyMCE_connect.js"></script>
```

Nel caso in cui la cartella esyFileManager sia in una posizione diversa dalla root del sito modificare il path nel file tinyMCE_connect.js con quello corretto

```
var cmsURL = "/esyFileManager/index.php?u=3"
```