<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

return array(
    'magl_legacy_application' => array(
        'doc_root' => 'public/', // the legacy apps DOCUMENT_ROOT for including files
        'globals' => array(
            'get' => true, // should $_GET be filled with variables from route match?
            'request' => true, // should $_GET be filled with variables from route match?
        ),
    ),
    'router' => array(
        'routes' => array(
            'legacy' => array(
                'type' => 'Zend\Mvc\Router\Http\Regex',
                'options' => array(
                    'regex'    => '(?<script>.+\.php)|/',
                    'defaults' => array(
                        'controller' => 'MaglLegacyApplication\Controller\Legacy',
                        'action'     => 'index',
                    ),
                    'spec' => '/',
                ),
            ),
            'legacy-static' => array(
                'type' => 'Zend\Mvc\Router\Http\Regex',
                'options' => array(
                    'regex'    => '(?<static>.+\.(js|css|jpg|png|gif|htm|html))',
                    'defaults' => array(
                        'controller' => 'MaglLegacyApplication\Controller\LegacyStatic',
                        'action'     => 'index',
                    ),
                    'spec' => '/',
                ),
            ),
            // example for transferring mod rewrite rules to zf2 routes
//            'legacy-seo-calendar' => array(
//                'type' => 'Zend\Mvc\Router\Http\Regex',
//                'options' => array(
//                    'regex'    => '/calendar/(?<foo>.+)',
//                    'defaults' => array(
//                        'controller' => 'MaglLegacyApplication\Controller\Legacy',
//                        'action'     => 'index',
//                        'script'     => 'index-seo.php',
//                    ),
//                    'spec' => '/',
//                ),
//            ),
        ),
    ),
);
