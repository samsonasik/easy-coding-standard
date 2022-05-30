<?php

declare (strict_types=1);
namespace ECSPrefix20220530\Symplify\VendorPatches;

use ECSPrefix20220530\Nette\Utils\Strings;
use ECSPrefix20220530\Symplify\VendorPatches\ValueObject\OldAndNewFileInfo;
final class PatchFileFactory
{
    public function createPatchFilePath(\ECSPrefix20220530\Symplify\VendorPatches\ValueObject\OldAndNewFileInfo $oldAndNewFileInfo, string $vendorDirectory) : string
    {
        $newFileInfo = $oldAndNewFileInfo->getNewFileInfo();
        $inVendorRelativeFilePath = $newFileInfo->getRelativeFilePathFromDirectory($vendorDirectory);
        $relativeFilePathWithoutSuffix = \ECSPrefix20220530\Nette\Utils\Strings::lower($inVendorRelativeFilePath);
        $pathFileName = \ECSPrefix20220530\Nette\Utils\Strings::webalize($relativeFilePathWithoutSuffix) . '.patch';
        return 'patches' . \DIRECTORY_SEPARATOR . $pathFileName;
    }
}
