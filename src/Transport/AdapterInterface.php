<?php

namespace Deployer\Transport;

interface AdapterInterface
{
    const USER_NAME = "user_name";

    public function authorize($authorizedCredentials = []);

    public function setData(array $data);

    public function setMethod($method);

    public function call();
}