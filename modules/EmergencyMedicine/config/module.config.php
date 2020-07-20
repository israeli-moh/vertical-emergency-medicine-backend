<?php
/* +-----------------------------------------------------------------------------+
 * Copyright 2019 matrix israel
 * LICENSE: This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see
 * http://www.gnu.org/licenses/licenses.html#GPL
 *    @author  Eyal Wolanowski <eyal.wolanowski@gmail.com>
 * +------------------------------------------------------------------------------+
 *
 */

use EmergencyMedicine\Controller\letterGeneratorController;
use Interop\Container\ContainerInterface;

return array(

    /* declare all controllers */

    'controllers' => array(
        'factories' => [
            letterGeneratorController::class => function (ContainerInterface $container, $requestedName) {
                return new letterGeneratorController($container);
            },
        ],
    ),

    /**
     * routing configuration.
     */
    'router' => array(
        'routes' => array(
            'letter_generator' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/letter-generator[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'method'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => letterGeneratorController::class,
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),


    'view_manager' => array(
        'template_path_stack' => array(
            'EmergencyMedicine' => __DIR__ . '/../view',
        ),
        /*
        'template_map' => array(
            'PatientVaccines/layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'PatientVaccines/layout/print' => __DIR__ . '/../view/layout/print.phtml',
        )
        */

    ),
);
