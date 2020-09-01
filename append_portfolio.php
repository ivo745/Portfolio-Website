<?php
    session_start();

    $name = $_REQUEST['name'];
    unset($_REQUEST['name']);
    
    $origname = '';
    $uploaddir = 'uploads/'.$_SESSION['SESS_USER_ID'].'/';

    // Assign thumbnail location and image width and height variables
    $thumbnail = substr_replace($name, 'c', strrpos($name, '.'), 0 );
    list($width, $height) = getimagesize($uploaddir.$thumbnail);

    // Creates XML string and XML document using the DOM
    $dom = new DomDocument('1.0', 'UTF-8');
    $filename = $uploaddir.'/filename.xml';
    $dom->load($filename);
    
    // xmldoc requires root, add it if it doesn't exist
    $root = $dom->documentElement;
    if ($root->nodeName != 'root') {
        $root = $dom->appendChild($dom->createElement('root'));
    }

    $div1 = $dom->createElement('div');
    $div2 = $dom->createElement('div');
    $a = $dom->createElement('a');
    $img = $dom->createElement('img');
    $form = $dom->createElement('form');
    $input1 = $dom->createElement('input');
    $input2 = $dom->createElement('input');

    $root->appendChild($div1);

    $div1->appendChild($dom->createAttribute('class'));
    $div1->setAttribute('class', 'polaroid');
    $div1->appendChild($dom->createAttribute('id'));
    $div1->setAttribute('id', $name);

    // Nest div2 in div1
    $div1->appendChild($div2);
    $div2->appendChild($dom->createAttribute('class'));
    $div2->setAttribute('class', 'container');
    $div2->appendChild($a);
    $div2->appendChild($form);

    $a->appendChild($dom->createAttribute('class'));
    $a->appendChild($dom->createAttribute('title'));
    $a->appendChild($dom->createAttribute('href'));
    $a->setAttribute('href', $uploaddir.$name);
    $a->setAttribute('class', 'zoom');
    $a->appendChild($img);

    $img->appendChild($dom->createAttribute('style'));
    $img->setAttribute('style', 'height:'.$height.'px; width:'.$width.'px;');
    $img->appendChild($dom->createAttribute('data-src'));
    $img->setAttribute('data-src', $uploaddir.$thumbnail);

    $form->appendChild($dom->createAttribute('method'));
    $form->appendChild($dom->createAttribute('action'));
    $form->appendChild($input1);
    $form->setAttribute('method', 'POST');
    $form->setAttribute('action', "javascript:deleteFile('$name');");
    
    $input1->appendChild($dom->createAttribute('type'));
    $input1->appendChild($input2);
    $input1->setAttribute('type', 'hidden');

    $input2->appendChild($dom->createAttribute('type'));
    $input2->appendChild($dom->createAttribute('value'));
    $input2->setAttribute('type', 'submit');
    $input2->setAttribute('value', 'Delete File');

    // Return newly added element
    echo $dom->saveXML($div1);
    $dom->save($filename);
?>