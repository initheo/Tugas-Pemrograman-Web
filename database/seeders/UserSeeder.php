<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['id' => 1, 'username' => 'validator2', 'password' => '$2y$10$V7z9OQH9hZM8ye75Q/4rmepz0pi6fOBgAnDOpgDXKQ3TlHQ3Tu9uS'],
            ['id' => 2, 'username' => 'validator3', 'password' => '$2y$10$rOrHOux.okJgDMsIsfo3NuWkvH2cRrOJwZdJTSF27YoSOVrUmEnD.'],
            ['id' => 3, 'username' => 'validator4', 'password' => '$2y$10$GWv/sRUK3.eFzxitt9wFFO.ota5iuLsu5kigK06jUdHTkbGbQqW.a'],
            ['id' => 4, 'username' => 'officer2', 'password' => '$2y$10$mgTW6Wkgs/KsyCyadyko1eK9EGGJkqa9.wUvQ8xM1CgqZi83T8T5e'],
            ['id' => 5, 'username' => 'officer3', 'password' => '$2y$10$kOn1NIOzTMatKONRfD15Fu7/bydNQYeUkeFmBVibpaoPod4Irwile'],
            ['id' => 6, 'username' => 'validator5', 'password' => '$2y$10$mdahUg9DO/xQj8Kuv92vgeQy0Jh2g8BePVhFzllVTryLlOJItpOEW'],
            ['id' => 7, 'username' => 'validator6', 'password' => '$2y$10$3bqtfrOff5ap7Vf7tJ6sEedA9/BWjkc0hIlEtlQklKidCKxxLrGEa'],
            ['id' => 8, 'username' => 'validator7', 'password' => '$2y$10$LvkcQMls02ndhFlmRYj80ORbEvAsQISQ0jup4o9OmJatla5BJx7n2'],
            ['id' => 9, 'username' => 'officer5', 'password' => '$2y$10$lE5Ro1yB8eMqPmvGr5TZo.H3PvakN0JJ4bQ3gcyZpeIerfSYMuwgy'],
            ['id' => 10, 'username' => 'officer6', 'password' => '$2y$10$G49YMKMsayKNntpVmjgieu45JaDr1EY1amj37i94Vnw6jmJ5v.xuy'],
            ['id' => 11, 'username' => 'validator8', 'password' => '$2y$10$6AOsg8r8I9JxGYzESet1Re6fguHiWYh6.xK4/CiWwbVJrwszsVEPO'],
            ['id' => 12, 'username' => 'validator9', 'password' => '$2y$10$vEpJNZVYVmxmGa6yLcmlse5hBzyS4AmIsCfU5Ium7h4P1BGxyxkva'],
            ['id' => 13, 'username' => 'validator10', 'password' => '$2y$10$FHuPvu2KdeJKiaXDAnJn3edcjogY8vggHT1tyFLdcj44VDx3AaNWe'],
            ['id' => 14, 'username' => 'officer8', 'password' => '$2y$10$6bbYntlsOWxN1149KRQoLuPxpqj7Fwom9QSxcQ/MJ.TJ/50DOcRWG'],
            ['id' => 15, 'username' => 'officer9', 'password' => '$2y$10$7dtqW7kllABipA8bHaZG4.I0GQpgznnnkMV1KCV5r37lwLC5PReDC'],
            ['id' => 16, 'username' => 'validator11', 'password' => '$2y$10$1sSY.iVLjdZ.nN6C1diGQuQe5A/ku9H5dGv5mpEwmOigx7Ku6SXT.'],
            ['id' => 17, 'username' => 'validator12', 'password' => '$2y$10$Et2lcahneYVmvqSMB0H3E.6jGrBURmKm4LZHbhvYQufsEsRr8MeMC'],
            ['id' => 18, 'username' => 'validator13', 'password' => '$2y$10$zMs5XMdw9UnVffXyM6ydlOXwfKY5/v6FyP8.eMnEqHxWl7OpeUjNO'],
            ['id' => 19, 'username' => 'officer11', 'password' => '$2y$10$4P7xMiRGstOOGMzdzmKt7O5uTh9pXh8WmSIg3TaXidpQpFPU9mwZS'],
            ['id' => 20, 'username' => 'officer12', 'password' => '$2y$10$vE8NMh6rmM0xencAduABTe8J7DmYMqP8wsYxNHdy1qU0bgehX1zEm'],
            ['id' => 21, 'username' => 'validator14', 'password' => '$2y$10$7fLg.UbvPNSXb8UvE2vkHeF.sV4Q82c.uvaBriJAsXKxj0FzFpHg6'],
            ['id' => 22, 'username' => 'validator15', 'password' => '$2y$10$pQ/1tvf6XF9S/swwk4Y7jOTuJm1/K4vDvlOmsuLI1lMtYyFukFBAW'],
            ['id' => 23, 'username' => 'validator16', 'password' => '$2y$10$CHCyk8QBkCR5qJTqG6f7re3ccR.VMbRrcHsbZYfh1EAhVl1ufheyi'],
            ['id' => 24, 'username' => 'officer14', 'password' => '$2y$10$rM/lVVEj2S2GmosC.2Lyu.Y3.yMnsUmzxViYGs66t.UZj5Pe/QGsu'],
            ['id' => 25, 'username' => 'officer15', 'password' => '$2y$10$NcAshNWgVKbdYQTZBNTXvOBqFHP6O2AwJUbvAm4Gja8HM7G1KyVSW'],
            ['id' => 26, 'username' => 'validator17', 'password' => '$2y$10$MN7EUEP7WEpx9CGYRy2tNOvpBwZYwCqj2tNpiKo4QIVaPC7ARcAH2'],
            ['id' => 27, 'username' => 'validator18', 'password' => '$2y$10$S4Z5eVPCEItajH7bUUMqZe.ncK7Xyq7ULPhaB1Af8EOk.iyi.pIa2'],
            ['id' => 28, 'username' => 'validator19', 'password' => '$2y$10$641mZPy3lze56Yd62Vdk8u5jLYt9iJhnXkwo//guI.R5c78dq.LuG'],
            ['id' => 29, 'username' => 'officer17', 'password' => '$2y$10$EvRoWw8ZJs9EnVxhKlQPO.O.KxsFxyby7iI6duleda6i.zPNGsxRu'],
            ['id' => 30, 'username' => 'officer18', 'password' => '$2y$10$U60MhOJNq2vHgOPRjUCB4.s3WsbeUFb6.kSy7N1db8rI3XFpZK5Yu'],
            ['id' => 31, 'username' => 'validator20', 'password' => '$2y$10$M9Zgl0c2ngaTR9HkB154fekeqGCarTNgdGnQa1LbBj256oJL6Nn/e'],
            ['id' => 32, 'username' => 'validator21', 'password' => '$2y$10$lBJLht2hCzdYGydSVwv.eOuhc.begKuWVqDqL7R1RgjejXr3yKwWS'],
            ['id' => 33, 'username' => 'validator22', 'password' => '$2y$10$Y/mZoTyQHJK3aNcR57KdUuoahcMvUfDiFmHSp/LzyybhDx8bmkQdS'],
            ['id' => 34, 'username' => 'officer20', 'password' => '$2y$10$sP/ikW5Qan9UrDgLkv3nEOIsV61RfnDvpOoXg3aK9hsQTdC1amWeC'],
            ['id' => 35, 'username' => 'officer21', 'password' => '$2y$10$//J0Hb5rFpW7MuyUYu6Rfu8mP0D6vZUjnquZSJsOL8TvKBuJkz8fe'],
            ['id' => 36, 'username' => 'validator23', 'password' => '$2y$10$GRmdMl81XBWBFMHppIIPd.ggbUtwX7ppYWIi/Wp1SFoDJSNBvrLii'],
            ['id' => 37, 'username' => 'validator24', 'password' => '$2y$10$AG/vUaRyzGNxUac3l3EOg.HjSwxGoKB4HbN7SQor0oPD3T9aENGRa'],
            ['id' => 38, 'username' => 'validator25', 'password' => '$2y$10$BGW0QtLlVVL6pwEMxo29X.UwW.oK9BGFEFVRU4j2Gr9.upAaCv1vq'],
            ['id' => 39, 'username' => 'officer23', 'password' => '$2y$10$lR.qikgtYjE3gJEATbkwNeRZzU5p232G/Ma0b.Ujl/FhLBjWDdRSG'],
            ['id' => 40, 'username' => 'officer24', 'password' => '$2y$10$qbzIQvYNKcqXpADHMj4KUugsV18e2GHqAWfrTND0fpfcdRSddPXWK'],
            ['id' => 41, 'username' => 'validator26', 'password' => '$2y$10$t3YFb0GECtPVmfFPVmSyk.8j1T78h3./OEv7qEmbASHM0wextK2v6'],
            ['id' => 42, 'username' => 'validator27', 'password' => '$2y$10$mZjsimCruvmGeMFP5n0AEOyPNHkqaWHzKTSq.P6.v77FiMmpn/p4.'],
            ['id' => 43, 'username' => 'validator28', 'password' => '$2y$10$iMXNS39pX7aHQhK3dernaO182ID6JEtHqGQ3J8YlMPBO5KxtvCJka'],
            ['id' => 44, 'username' => 'officer26', 'password' => '$2y$10$h9ELcDTKj7RDmTJc8EPRjuapfpQBl1JxIB0mPNdEHKXCFQyBi2Ki2'],
            ['id' => 45, 'username' => 'officer27', 'password' => '$2y$10$hdZvbbf2IJCXzRRcdagABujMEE5Yn0957lrsOKXCJUOUgAl42xbnW'],
            ['id' => 46, 'username' => 'validator29', 'password' => '$2y$10$jRj2r8rz1R/9VhltykU3mOXS8kE/QoV/g5w8L21n8mE9aRQBqF0Za'],
            ['id' => 47, 'username' => 'validator30', 'password' => '$2y$10$3U3cboyx2sWV9q8q6pE5peOk8z0JGXXeuq.Ec1/i.ubmgMdPU1OAq'],
            ['id' => 48, 'username' => 'validator31', 'password' => '$2y$10$.8YtovrrXJY0peoOZQd9meqfufh5I3ufChiTyDdT5cB.r1QqmTLj2'],
            ['id' => 49, 'username' => 'officer29', 'password' => '$2y$10$CylKSQ9n9ch4Eve.Nghq7Obeq.mcz7iVYlqk8MZQdW1X60nB8YlI6'],
            ['id' => 50, 'username' => 'officer30', 'password' => '$2y$10$f8v.1AnOVhaGQQJLpwPeZ.Uuj/lJc1EW9fSEADbRs3l0LgBIyMsnm'],
            ['id' => 51, 'username' => 'validator32', 'password' => '$2y$10$pqMPqIKLFHbba/JZmcSrF.Zbs3tqwwv1yPeq5LDpDZkS6XZ0lQosK'],
            ['id' => 52, 'username' => 'validator33', 'password' => '$2y$10$w6gb2/wthVt.D851iWVMV.eeTg2cUuJaKUl3Zre.7d16M9RVzsk/S'],
            ['id' => 53, 'username' => 'validator34', 'password' => '$2y$10$DT31BLPJXocCysZATI2wc.zUcLphroJ9JnT5vJukC3LEmyI8nlgyO'],
            ['id' => 54, 'username' => 'officer32', 'password' => '$2y$10$Bz4QX7lfmZ6XzIL8d54hQelHJ/W3oIeHjs2gpqtdUF0ilpocc0i12'],
            ['id' => 55, 'username' => 'officer33', 'password' => '$2y$10$jIIiDhxn25u5w5CyjRK0muk8a95wIDyqdZqWb4064WRtcqNOFD4qi'],
            ['id' => 56, 'username' => 'validator35', 'password' => '$2y$10$5iiqslrC1UjpIr5mUr4eFeUKg06JDVwY.ABsLNH/mrs2NZn5P9w5W'],
            ['id' => 57, 'username' => 'validator36', 'password' => '$2y$10$2yp2Sa8MM/gwkaz/fb.VceEvw6YQ9zqH2TcGEgQnwpoAkfP03Bnr2'],
            ['id' => 58, 'username' => 'validator37', 'password' => '$2y$10$yB9QkeTaabcNqMNOu0kUUOZ1jtgF06qi61mtnX9pFO6UkQWj4iBvu'],
            ['id' => 59, 'username' => 'officer35', 'password' => '$2y$10$UOX.akGzKvL1gLrWRioGBu3vonMt0KKVuLAA2cOVLPuRFmYPCkoEu'],
            ['id' => 60, 'username' => 'officer36', 'password' => '$2y$10$kJ.EC6WMaAerfVwIUhvLm.lMysMp2OrQsFxMkHibwakNdUXVo2dwi'],
            ['id' => 61, 'username' => 'validator38', 'password' => '$2y$10$PeJ6hc7F/yqAVn6BMFkmoOqots5nfVlg.vkit.MsxXIOLzgKQmzNS'],
            ['id' => 62, 'username' => 'validator39', 'password' => '$2y$10$Y/z3/H7dxCODjSktd8o7RO4GjTBu0GgYtjXzUuy6gBVQRK6q7YP2e'],
            ['id' => 63, 'username' => 'validator40', 'password' => '$2y$10$kF0b0mJPVKvlT.WhQm52ReNwAgYzfLnh.l//tdQ9v8FWGrHrjrfqK'],
            ['id' => 64, 'username' => 'officer38', 'password' => '$2y$10$c/HPFLBj8Ms6ACTKwUsBPuMODyopjA5u5/.trDxacDncdqqjUDMee'],
            ['id' => 65, 'username' => 'officer39', 'password' => '$2y$10$QdedI8c2E5nMta1.6NyXY.28g3malBKilhHbWWZfZpek4x9Uoe3fS'],
            ['id' => 66, 'username' => 'validator41', 'password' => '$2y$10$SZruoxjIMWWTIfrYlaYq9eRI.eozOrkuGb8LtAyXIZtS14cU7wKHS'],
            ['id' => 67, 'username' => 'validator42', 'password' => '$2y$10$Fv.HBZ28qG5FeskggImjMekFOGkwAnpbtsia.qkUgoYxQpyXBH.tG'],
            ['id' => 68, 'username' => 'validator43', 'password' => '$2y$10$HEYvBl7rkq1Znmb6uGnZEe6.5JzTOdp9A3bu71oaIEZj8OqJgW7EO'],
            ['id' => 69, 'username' => 'officer41', 'password' => '$2y$10$3c.aTUHy5f/zIikynhA7vOqNEqes1OBqzEzS1.1Dgr3jj/Ps.sy5K'],
            ['id' => 70, 'username' => 'officer42', 'password' => '$2y$10$4OUqJgVuwK1Lfbqhbt4Iv./IGZTxTY84zLKT3WkETVJG8pryDfQUe'],
            ['id' => 71, 'username' => 'validator44', 'password' => '$2y$10$hxqc5IlwAKIhA9RkEA8iOeCbXXUgtr5sgkQUCtOVIfRn.H1wmLdUq'],
            ['id' => 72, 'username' => 'validator45', 'password' => '$2y$10$cNptHZZ8ZrOusJs49mQ8zuT2VUgRh5WOFVDHEboCP5RdbrPM02PTW'],
            ['id' => 73, 'username' => 'validator46', 'password' => '$2y$10$CZKA4E3DUr0N6UOx8tkwueL438dNQRSpToqqs8VaT/a06X7ksVmyC'],
            ['id' => 74, 'username' => 'officer44', 'password' => '$2y$10$./todE9ybLYEE4qwMU/WUO9CIbU1IgJ4rE7ZaDn10Xx67Tow2u7iG'],
            ['id' => 75, 'username' => 'officer45', 'password' => '$2y$10$T8bOs2y82y8EaPV3XUi0heGLWCukmQOfzItOE9W0c.OJ66UJewXye'],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
