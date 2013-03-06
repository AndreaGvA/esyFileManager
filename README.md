##### [![SmartGaP](http://tst.smartgap.it/admin/templates/SmartGaP_new/images/logo.png)](http://www.smartgap.it)

# esyFileManager 
______________

**Versione 0.9b**

È un filemanager openSource scritto in PHP e jQuery che lavora direttamente sul filesystem senza l'ausilio di un database.

EsyFileManager non necessita di installazioni particolari sul server ed è semplicissimo da installare

È possibile utilizzare esyfilemanager per selezionare file all'interno di un campo di input.

EsyFileManager può essere usato come plugin per editor di testi WysWyg come cKeditor

Il software è rilasciato con le licenze open source [GPL](http://www.gnu.org/licenses/gpl-2.0.txt) e [LGPL](http://www.gnu.org/licenses/lgpl-3.0.txt)

______________

#### EsyFileManager utilizza le seguenti librerie OpenSource:

* file-uploader | <https://github.com/valums/file-uploader>
* jQuery URL Parser | <https://github.com/allmarkedup/jQuery-URL-Parser>
* jQuery | <http://jquery.com/>
* jQuery ui | <http://jqueryui.com/>

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