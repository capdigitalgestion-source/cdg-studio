<?php

declare(strict_types=1);

namespace CDGStudio\Modules\Settings;

use CDGStudio\Contracts\SettingsProviderInterface;
use CDGStudio\Modules\Settings\DTO\SettingsField;
use CDGStudio\Modules\Settings\DTO\SettingsSection;

final class SettingsRegistry
{
    /**
     * @var array<string, SettingsSection>
     */
    private array $sections = [];

    /**
     * @var array<string, SettingsField>
     */
    private array $fields = [];

    /**
     * @var list<SettingsProviderInterface>
     */
    private array $providers = [];

    public function addProvider(SettingsProviderInterface $provider): void
    {
        $this->providers[] = $provider;
    }

    public function boot(): void
    {
        foreach ($this->providers as $provider) {
            $provider->register($this);
        }
    }

    public function addSection(SettingsSection $section): void
    {
        $this->sections[$section->id] = $section;
    }

    public function addField(SettingsField $field): void
    {
        $this->fields[$field->key] = $field;
    }

    /**
     * @return array<string, SettingsSection>
     */
    public function sections(): array
    {
        uasort(
            $this->sections,
            static fn (SettingsSection $a, SettingsSection $b): int => $a->order <=> $b->order
        );

        return $this->sections;
    }

    /**
     * @return array<string, SettingsField>
     */
    public function fields(): array
    {
        return $this->fields;
    }

    /**
     * @return array<string, SettingsField>
     */
    public function fieldsForSection(string $sectionId): array
    {
        return array_filter(
            $this->fields,
            static fn (SettingsField $field): bool => $field->section === $sectionId
        );
    }
}