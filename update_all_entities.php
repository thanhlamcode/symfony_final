<?php

$entities = [
    'Order',
    'OrderItem', 
    'Coupon',
    'PromotionProgram',
    'MemberShipLevel',
    'CustomerPointTransaction',
    'CouponOrder',
    'ReturnOrder',
    'OrderFeedback',
    'ShopFeedback',
    'StaffFeedback',
    'ShopSetting'
];

foreach ($entities as $entity) {
    $file = "src/Entity/{$entity}.php";
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Add copyright header if not exists
        if (!str_contains($content, 'Copyright (c) 2025 Fastboy Marketing')) {
            $content = "<?php\n\n/**\n * Copyright (c) 2025 Fastboy Marketing\n */\n\ndeclare (strict_types = 1);\n\n" . substr($content, 6);
        }
        
        // Remove UuidGenerator import if exists
        $content = str_replace("use App\Service\UuidGenerator;\n", "", $content);
        
        // Update ID field to use custom generator
        $content = preg_replace(
            '/#\[ORM\\\Id\][^#]*#\[ORM\\\Column\(type: \'uuid\', unique: true\)\][^#]*private UuidV7 \$id;/s',
            "#[ORM\Id]\n    #[ORM\GeneratedValue(strategy: 'CUSTOM')]\n    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]\n    #[ORM\Column(type: 'uuid', unique: true)]\n    #[Groups(['api:" . strtolower($entity) . ":read'])]\n    private ?UuidV7 \$id = null;",
            $content
        );
        
        // Update constructor to remove manual ID generation
        $content = preg_replace(
            '/public function __construct\(\)\s*\{[^}]*\$this->id = UuidGenerator::generate\(\);[^}]*\}/s',
            "public function __construct()\n    {\n    }",
            $content
        );
        
        // Update getId method return type
        $content = str_replace(
            'public function getId(): UuidV7',
            'public function getId(): ?UuidV7',
            $content
        );
        
        // Update timestamp fields to use datetime instead of datetime_immutable
        $content = str_replace(
            ["#[ORM\Column(type: 'datetime_immutable')]", "private ?\\DateTimeImmutable", "\\DateTimeImmutable"],
            ["#[ORM\Column(type: 'datetime')]", "private \\DateTimeInterface", "\\DateTimeInterface"],
            $content
        );
        
        // Update Groups to use consistent naming
        $content = str_replace(
            ['api:' . strtolower($entity) . ':get', 'api:' . strtolower($entity) . ':get_collection', 'api:' . strtolower($entity)],
            'api:' . strtolower($entity) . ':read',
            $content
        );
        
        // Update setter methods to return void instead of static
        $content = preg_replace(
            '/public function set([A-Za-z]+)\([^)]+\): static\s*\{[^}]*return \$this;[^}]*\}/s',
            'public function set$1($2): void$3',
            $content
        );
        
        file_put_contents($file, $content);
        echo "Updated {$entity}.php\n";
    }
}

echo "All entities updated!\n"; 