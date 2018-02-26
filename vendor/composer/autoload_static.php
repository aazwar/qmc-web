<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb73475b00fe579a5fd8402b76060cdab
{
    public static $files = array (
        '5255c38a0faeba867671b61dfda6d864' => __DIR__ . '/..' . '/paragonie/random_compat/lib/random.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
        'da253f61703e9c22a5a34f228526f05a' => __DIR__ . '/..' . '/wixel/gump/gump.class.php',
        'c65d09b6820da036953a371c8c73a9b1' => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook/polyfills.php',
    );

    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Respect\\Validation\\' => 19,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
        ),
        'L' => 
        array (
            'League\\OAuth2\\Server\\' => 21,
            'League\\Event\\' => 13,
            'Lcobucci\\JWT\\' => 13,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
        'F' => 
        array (
            'Faker\\' => 6,
            'Facebook\\' => 9,
        ),
        'D' => 
        array (
            'Defuse\\Crypto\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Respect\\Validation\\' => 
        array (
            0 => __DIR__ . '/..' . '/respect/validation/library',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'League\\OAuth2\\Server\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/oauth2-server/src',
        ),
        'League\\Event\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/event/src',
        ),
        'Lcobucci\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/lcobucci/jwt/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
        'Faker\\' => 
        array (
            0 => __DIR__ . '/..' . '/fzaninotto/faker/src/Faker',
        ),
        'Facebook\\' => 
        array (
            0 => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook',
        ),
        'Defuse\\Crypto\\' => 
        array (
            0 => __DIR__ . '/..' . '/defuse/php-encryption/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'PHPExcel' => 
            array (
                0 => __DIR__ . '/..' . '/phpoffice/phpexcel/Classes',
            ),
        ),
    );

    public static $classMap = array (
        'Access' => __DIR__ . '/..' . '/xfra35/f3-access/lib/access.php',
        'Audit' => __DIR__ . '/..' . '/bcosca/fatfree-core/audit.php',
        'Auth' => __DIR__ . '/..' . '/bcosca/fatfree-core/auth.php',
        'Base' => __DIR__ . '/..' . '/bcosca/fatfree-core/base.php',
        'Basket' => __DIR__ . '/..' . '/bcosca/fatfree-core/basket.php',
        'Bcrypt' => __DIR__ . '/..' . '/bcosca/fatfree-core/bcrypt.php',
        'CGIF' => __DIR__ . '/..' . '/mpdf/mpdf/classes/gif.php',
        'CGIFCOLORTABLE' => __DIR__ . '/..' . '/mpdf/mpdf/classes/gif.php',
        'CGIFFILEHEADER' => __DIR__ . '/..' . '/mpdf/mpdf/classes/gif.php',
        'CGIFIMAGE' => __DIR__ . '/..' . '/mpdf/mpdf/classes/gif.php',
        'CGIFIMAGEHEADER' => __DIR__ . '/..' . '/mpdf/mpdf/classes/gif.php',
        'CGIFLZW' => __DIR__ . '/..' . '/mpdf/mpdf/classes/gif.php',
        'CLI\\Agent' => __DIR__ . '/..' . '/bcosca/fatfree-core/cli/ws.php',
        'CLI\\WS' => __DIR__ . '/..' . '/bcosca/fatfree-core/cli/ws.php',
        'Cache' => __DIR__ . '/..' . '/bcosca/fatfree-core/base.php',
        'DB\\Cortex' => __DIR__ . '/..' . '/ikkez/f3-cortex/lib/db/cortex.php',
        'DB\\CortexCollection' => __DIR__ . '/..' . '/ikkez/f3-cortex/lib/db/cortex.php',
        'DB\\CortexQueryParser' => __DIR__ . '/..' . '/ikkez/f3-cortex/lib/db/cortex.php',
        'DB\\Cursor' => __DIR__ . '/..' . '/bcosca/fatfree-core/db/cursor.php',
        'DB\\Jig' => __DIR__ . '/..' . '/bcosca/fatfree-core/db/jig.php',
        'DB\\Jig\\Mapper' => __DIR__ . '/..' . '/bcosca/fatfree-core/db/jig/mapper.php',
        'DB\\Jig\\Session' => __DIR__ . '/..' . '/bcosca/fatfree-core/db/jig/session.php',
        'DB\\Mongo' => __DIR__ . '/..' . '/bcosca/fatfree-core/db/mongo.php',
        'DB\\Mongo\\Mapper' => __DIR__ . '/..' . '/bcosca/fatfree-core/db/mongo/mapper.php',
        'DB\\Mongo\\Session' => __DIR__ . '/..' . '/bcosca/fatfree-core/db/mongo/session.php',
        'DB\\SQL' => __DIR__ . '/..' . '/bcosca/fatfree-core/db/sql.php',
        'DB\\SQL\\Column' => __DIR__ . '/..' . '/ikkez/f3-schema-builder/lib/db/sql/schema.php',
        'DB\\SQL\\DB_Utils' => __DIR__ . '/..' . '/ikkez/f3-schema-builder/lib/db/sql/schema.php',
        'DB\\SQL\\Mapper' => __DIR__ . '/..' . '/bcosca/fatfree-core/db/sql/mapper.php',
        'DB\\SQL\\Schema' => __DIR__ . '/..' . '/ikkez/f3-schema-builder/lib/db/sql/schema.php',
        'DB\\SQL\\Session' => __DIR__ . '/..' . '/bcosca/fatfree-core/db/sql/session.php',
        'DB\\SQL\\TableBuilder' => __DIR__ . '/..' . '/ikkez/f3-schema-builder/lib/db/sql/schema.php',
        'DB\\SQL\\TableCreator' => __DIR__ . '/..' . '/ikkez/f3-schema-builder/lib/db/sql/schema.php',
        'DB\\SQL\\TableModifier' => __DIR__ . '/..' . '/ikkez/f3-schema-builder/lib/db/sql/schema.php',
        'F3' => __DIR__ . '/..' . '/bcosca/fatfree-core/f3.php',
        'FAL' => __DIR__ . '/..' . '/ikkez/f3-fal/lib/fal.php',
        'FAL\\Dropbox' => __DIR__ . '/..' . '/ikkez/f3-fal/lib/fal/dropbox.php',
        'FAL\\FTP' => __DIR__ . '/..' . '/ikkez/f3-fal/lib/fal/ftp.php',
        'FAL\\FileFilter' => __DIR__ . '/..' . '/ikkez/f3-fal/lib/fal/localfs.php',
        'FAL\\FileStream' => __DIR__ . '/..' . '/ikkez/f3-fal/lib/fal/filestream.php',
        'FAL\\FileSystem' => __DIR__ . '/..' . '/ikkez/f3-fal/lib/fal/filesystem.php',
        'FAL\\LocalFS' => __DIR__ . '/..' . '/ikkez/f3-fal/lib/fal/localfs.php',
        'FAL\\MetaFileStorage' => __DIR__ . '/..' . '/ikkez/f3-fal/lib/fal/metafilestorage.php',
        'FAL\\MetaStorageInterface' => __DIR__ . '/..' . '/ikkez/f3-fal/lib/fal/metastorageinterface.php',
        'FPDF_TPL' => __DIR__ . '/..' . '/setasign/fpdi/fpdf_tpl.php',
        'FPDI' => __DIR__ . '/..' . '/setasign/fpdi/fpdi.php',
        'FacebookStrategy' => __DIR__ . '/..' . '/ikkez/f3-opauth/lib/opauth/Strategy/Facebook/FacebookStrategy.php',
        'FilterASCII85' => __DIR__ . '/..' . '/setasign/fpdi/filters/FilterASCII85.php',
        'FilterASCIIHexDecode' => __DIR__ . '/..' . '/setasign/fpdi/filters/FilterASCIIHexDecode.php',
        'FilterLZW' => __DIR__ . '/..' . '/setasign/fpdi/filters/FilterLZW.php',
        'GithubStrategy' => __DIR__ . '/..' . '/ikkez/f3-opauth/lib/opauth/Strategy/Github/GithubStrategy.php',
        'GoogleStrategy' => __DIR__ . '/..' . '/ikkez/f3-opauth/lib/opauth/Strategy/Google/GoogleStrategy.php',
        'INDIC' => __DIR__ . '/..' . '/mpdf/mpdf/classes/indic.php',
        'ISO' => __DIR__ . '/..' . '/bcosca/fatfree-core/base.php',
        'Image' => __DIR__ . '/..' . '/bcosca/fatfree-core/image.php',
        'Log' => __DIR__ . '/..' . '/bcosca/fatfree-core/log.php',
        'MYANMAR' => __DIR__ . '/..' . '/mpdf/mpdf/classes/myanmar.php',
        'Magic' => __DIR__ . '/..' . '/bcosca/fatfree-core/magic.php',
        'Markdown' => __DIR__ . '/..' . '/bcosca/fatfree-core/markdown.php',
        'Matrix' => __DIR__ . '/..' . '/bcosca/fatfree-core/matrix.php',
        'OTLdump' => __DIR__ . '/..' . '/mpdf/mpdf/classes/otl_dump.php',
        'Opauth' => __DIR__ . '/..' . '/ikkez/f3-opauth/lib/opauth/Opauth.php',
        'OpauthBridge' => __DIR__ . '/..' . '/ikkez/f3-opauth/lib/opauth/OpauthBridge.php',
        'OpauthStrategy' => __DIR__ . '/..' . '/ikkez/f3-opauth/lib/opauth/OpauthStrategy.php',
        'PDFBarcode' => __DIR__ . '/..' . '/mpdf/mpdf/classes/barcode.php',
        'Prefab' => __DIR__ . '/..' . '/bcosca/fatfree-core/base.php',
        'Preview' => __DIR__ . '/..' . '/bcosca/fatfree-core/base.php',
        'Registry' => __DIR__ . '/..' . '/bcosca/fatfree-core/base.php',
        'SEA' => __DIR__ . '/..' . '/mpdf/mpdf/classes/sea.php',
        'SMTP' => __DIR__ . '/..' . '/bcosca/fatfree-core/smtp.php',
        'SVG' => __DIR__ . '/..' . '/mpdf/mpdf/classes/svg.php',
        'Session' => __DIR__ . '/..' . '/bcosca/fatfree-core/session.php',
        'TTFontFile' => __DIR__ . '/..' . '/mpdf/mpdf/classes/ttfontsuni.php',
        'TTFontFile_Analysis' => __DIR__ . '/..' . '/mpdf/mpdf/classes/ttfontsuni_analysis.php',
        'Template' => __DIR__ . '/..' . '/bcosca/fatfree-core/template.php',
        'Test' => __DIR__ . '/..' . '/bcosca/fatfree-core/test.php',
        'TwitterStrategy' => __DIR__ . '/..' . '/ikkez/f3-opauth/lib/opauth/Strategy/Twitter/TwitterStrategy.php',
        'UCDN' => __DIR__ . '/..' . '/mpdf/mpdf/classes/ucdn.php',
        'UTF' => __DIR__ . '/..' . '/bcosca/fatfree-core/utf.php',
        'View' => __DIR__ . '/..' . '/bcosca/fatfree-core/base.php',
        'Web' => __DIR__ . '/..' . '/bcosca/fatfree-core/web.php',
        'Web\\Geo' => __DIR__ . '/..' . '/bcosca/fatfree-core/web/geo.php',
        'Web\\Google\\Recaptcha' => __DIR__ . '/..' . '/bcosca/fatfree-core/web/google/recaptcha.php',
        'Web\\Google\\StaticMap' => __DIR__ . '/..' . '/bcosca/fatfree-core/web/google/staticmap.php',
        'Web\\OAuth2' => __DIR__ . '/..' . '/bcosca/fatfree-core/web/oauth2.php',
        'Web\\OpenID' => __DIR__ . '/..' . '/bcosca/fatfree-core/web/openid.php',
        'Web\\Pingback' => __DIR__ . '/..' . '/bcosca/fatfree-core/web/pingback.php',
        'bmp' => __DIR__ . '/..' . '/mpdf/mpdf/classes/bmp.php',
        'cssmgr' => __DIR__ . '/..' . '/mpdf/mpdf/classes/cssmgr.php',
        'directw' => __DIR__ . '/..' . '/mpdf/mpdf/classes/directw.php',
        'fpdi_pdf_parser' => __DIR__ . '/..' . '/setasign/fpdi/fpdi_pdf_parser.php',
        'grad' => __DIR__ . '/..' . '/mpdf/mpdf/classes/grad.php',
        'mPDF' => __DIR__ . '/..' . '/mpdf/mpdf/mpdf.php',
        'meter' => __DIR__ . '/..' . '/mpdf/mpdf/classes/meter.php',
        'mpdfform' => __DIR__ . '/..' . '/mpdf/mpdf/classes/mpdfform.php',
        'otl' => __DIR__ . '/..' . '/mpdf/mpdf/classes/otl.php',
        'pdf_context' => __DIR__ . '/..' . '/setasign/fpdi/pdf_context.php',
        'tmhOAuth' => __DIR__ . '/..' . '/ikkez/f3-opauth/lib/opauth/Strategy/Twitter/Vendor/tmhOAuth/tmhOAuth.php',
        'tmhUtilities' => __DIR__ . '/..' . '/ikkez/f3-opauth/lib/opauth/Strategy/Twitter/Vendor/tmhOAuth/tmhUtilities.php',
        'tocontents' => __DIR__ . '/..' . '/mpdf/mpdf/classes/tocontents.php',
        'wmf' => __DIR__ . '/..' . '/mpdf/mpdf/classes/wmf.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb73475b00fe579a5fd8402b76060cdab::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb73475b00fe579a5fd8402b76060cdab::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitb73475b00fe579a5fd8402b76060cdab::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitb73475b00fe579a5fd8402b76060cdab::$classMap;

        }, null, ClassLoader::class);
    }
}