<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'benchalu_budgetmvc';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'benchalu_PersonalBudgetAdmin';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'T@urus$1418';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * Secret key for hashing
     * @var boolean
     */
    const SECRET_KEY = 'your-secret-key';

    /**
     * Mailgun API key
     *
     * @var string
     */
#const MAILGUN_API_KEY = '1d2bdcd35bdd57e6a36fb054e8736445-73e57fef-962a5a30';

    /**
     * Mailgun domain
     *
     * @var string
     */
#const MAILGUN_DOMAIN = 'https://api.eu.mailgun.net/v3/mg.benchalubinski.pl';
}
