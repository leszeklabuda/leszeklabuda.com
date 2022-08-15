<?= $this->extend(setting('Pages.views')['layout']) ?>

<?= $this->section('title') ?><?= lang('Pages.home') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

<?= $this->include('templates/timestamp') ?>

<?= $this->include('templates/nbp') ?>

<?= $this->endSection() ?>

<?php
