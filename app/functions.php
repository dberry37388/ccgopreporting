<?php

/**
 * Returns the date for the given election.
 *
 * @param $election
 * @return mixed
 */
function getElectionDate($election) {
    return config("votelist.elections.{$election}");
}

function getVoteCode($code) {
    return config("votelist.vote_code_map.{$code}");
}
