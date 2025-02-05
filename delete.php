<?php


require_once __DIR__ . '/lib/Application.php';
Horde_Registry::appInit('trean');

$bookmark_id = (int)Horde_Util::getFormData('bookmark');
$errorMsg    = _("There was a problem deleting the bookmark: %s");

try {
    $bookmark = $trean_gateway->getBookmark($bookmark_id);

    if ($trean_gateway->removeBookMark($bookmark) === true) {

        $notification->push(sprintf(_("Bookmark succesfully deleted!")), 'horde.message');
    }
    else {
        $notification->push(sprintf(_($errorMsg, 'false')), 'horde.error');
    }
}
catch (Horde_Exception_NotFound $e) {
    $notification->push(sprintf(_("Bookmark not found: %s."), $e->getMessage()), 'horde.error');
}

catch (Horde_Exception_PermissionDenied $e) {
    $notification->push(sprintf($errorMsg, "No permission"), 'horde.error');
}
catch (Exception $e) {
    $notification->push(sprintf($errorMsg, $e->getMessage()), 'horde.error');
}

Horde::url('browse.php', true)->redirect();
