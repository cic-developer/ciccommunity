const token_abi = [{
        constant: true,
        inputs: [],
        name: "name",
        outputs: [{ name: "", type: "string" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_spender", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "approve",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "totalSupply",
        outputs: [{ name: "", type: "uint256" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_from", type: "address" },
            { name: "_to", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "transferFrom",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "decimals",
        outputs: [{ name: "", type: "uint8" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [{ name: "_value", type: "uint256" }],
        name: "burn",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [{ name: "", type: "address" }],
        name: "balanceOf",
        outputs: [{ name: "", type: "uint256" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_from", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "burnFrom",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: false,
        inputs: [],
        name: "release",
        outputs: [],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "owner",
        outputs: [{ name: "", type: "address" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "symbol",
        outputs: [{ name: "", type: "string" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "released",
        outputs: [{ name: "", type: "bool" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_to", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "transfer",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [{ name: "", type: "address" }],
        name: "frozenAccount",
        outputs: [{ name: "", type: "bool" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_spender", type: "address" },
            { name: "_value", type: "uint256" },
            { name: "_extraData", type: "bytes" },
        ],
        name: "approveAndCall",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [
            { name: "", type: "address" },
            { name: "", type: "address" },
        ],
        name: "allowance",
        outputs: [{ name: "", type: "uint256" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "target", type: "address" },
            { name: "freeze", type: "bool" },
        ],
        name: "freezeAccount",
        outputs: [],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: false,
        inputs: [{ name: "newOwner", type: "address" }],
        name: "transferOwnership",
        outputs: [],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        inputs: [
            { name: "initialSupply", type: "uint256" },
            { name: "tokenName", type: "string" },
            { name: "tokenSymbol", type: "string" },
        ],
        payable: false,
        stateMutability: "nonpayable",
        type: "constructor",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: false, name: "target", type: "address" },
            { indexed: false, name: "frozen", type: "bool" },
        ],
        name: "FrozenFunds",
        type: "event",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: true, name: "from", type: "address" },
            { indexed: true, name: "to", type: "address" },
            { indexed: false, name: "value", type: "uint256" },
        ],
        name: "Transfer",
        type: "event",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: true, name: "_owner", type: "address" },
            { indexed: true, name: "_spender", type: "address" },
            { indexed: false, name: "_value", type: "uint256" },
        ],
        name: "Approval",
        type: "event",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: true, name: "from", type: "address" },
            { indexed: false, name: "value", type: "uint256" },
        ],
        name: "Burn",
        type: "event",
    },
];
const contract_abi = [{
        "constant": false,
        "inputs": [],
        "name": "acceptOwnership",
        "outputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "constant": false,
        "inputs": [{
                "name": "_from",
                "type": "address"
            },
            {
                "name": "_to",
                "type": "address"
            },
            {
                "name": "_value",
                "type": "uint256"
            },
            {
                "name": "_url",
                "type": "string"
            },
            {
                "name": "_id",
                "type": "string"
            }
        ],
        "name": "deposit_enter",
        "outputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "constant": false,
        "inputs": [],
        "name": "exit",
        "outputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "constant": false,
        "inputs": [],
        "name": "setFreeze",
        "outputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "constant": false,
        "inputs": [{
            "name": "_newManager",
            "type": "address"
        }],
        "name": "transferOwnership",
        "outputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "inputs": [{
            "name": "_tokenAddress",
            "type": "address"
        }],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "constructor"
    },
    {
        "anonymous": false,
        "inputs": [{
                "indexed": false,
                "name": "from",
                "type": "address"
            },
            {
                "indexed": false,
                "name": "to",
                "type": "address"
            },
            {
                "indexed": false,
                "name": "value",
                "type": "uint256"
            },
            {
                "indexed": false,
                "name": "url",
                "type": "string"
            },
            {
                "indexed": false,
                "name": "id",
                "type": "string"
            }
        ],
        "name": "deposit",
        "type": "event"
    },
    {
        "constant": true,
        "inputs": [],
        "name": "freeze",
        "outputs": [{
            "name": "",
            "type": "bool"
        }],
        "payable": false,
        "stateMutability": "view",
        "type": "function"
    },
    {
        "constant": true,
        "inputs": [],
        "name": "manager",
        "outputs": [{
            "name": "",
            "type": "address"
        }],
        "payable": false,
        "stateMutability": "view",
        "type": "function"
    },
    {
        "constant": true,
        "inputs": [],
        "name": "newManager",
        "outputs": [{
            "name": "",
            "type": "address"
        }],
        "payable": false,
        "stateMutability": "view",
        "type": "function"
    },
    {
        "constant": true,
        "inputs": [],
        "name": "tokenAddress",
        "outputs": [{
            "name": "",
            "type": "address"
        }],
        "payable": false,
        "stateMutability": "view",
        "type": "function"
    }
]
const contract_address = "0x5682461966BB835da2C55c883E5C5985c54829e6";
const token_address = "0x7eee60a000986e9efe7f5c90340738558c24317b";
let csrf_key = '';
let csrf_token = '';
let userWallet_in_mypage = '';

$(document).on('ready', async function() {
    const klaytn = window.klaytn;
    if (klaytn === undefined) {
        alert('Klaytn Kaikas가 설치되지 않았습니다.\nKlaytn Kaikas을 설치하여 주세요');
        history.back();
    }

    const PER = new caver.klay.Contract(token_abi, token_address);
    const DEPOSIT = new caver.klay.Contract(contract_abi, contract_address)

    $('.modal_open1').on('click', async function() {
        var reg_num = /^[0-9]*$/;
        let closest_tr = $(this).closest('tr');
        let children_td = closest_tr.children('td');
        // console.log(children_td[4].innerText);
        let _cal_money = $(this).data('cal-money'); // 수수료를 제한 출금할 cp 
        let _userAddress = children_td[4].innerText;

        let cal_money = parseFloat(_cal_money);
        let price = parseFloat(per_price);

        let _per_coin = (cal_money / price) * 100;

        let per_coin = Math.floor((_per_coin * 100)) / 100; // 예상 퍼코인
        let _findex = String(per_coin).indexOf(".");
        let _length = 0;
        if (_findex != -1) {
            _length = String(per_coin).substring(_findex).length;
        }

        // 충전액 필숫값
        if (!_price) {
            alert('충전액을 입력해주십시오.');
            return false;
        }

        let caver_value = "0";

        if (_length) {
            console.log("1");
            caver_value = caver.utils.toBN(per_coin * Math.pow(10, _length)).mul(caver.utils.toBN(Number(`1e${18 - _length}`))).toString();
        } else {
            console.log("2");
            caver_value = caver.utils.toBN(per_coin).mul(caver.utils.toBN(Number(`1e${18}`))).toString();
        }

        await klaytn.enable();
        // 클레이튼에 접속되어있는 월렛주소
        const account = klaytn.selectedAddress;
        const token_balance = await PER.methods.balanceOf(account).call();

        const network = klaytn.networkVersion;
        const selected_addr = account;
        const per_token = token_balance / 1000000000000000000;

        if (network !== 8217) {
            alert('Klaytn Kaikas의 Network를\nMain network로 바꿔주세요');
            location.reload();
            return;
        }
        if (!selected_addr) {
            alert('Klaytn Kaikas의 주소를 다시 확인해주세요');
            location.reload();
            return;
        }
        if (per_token < 0) {
            alert('Klaytn Kaikas에 PER 코인이 없습니다.\nPER 코인을 추가 또는 충전해주세요');
            location.reload();
            return;
        }

        const sendToPerWallet_data = await caver.klay.abi.encodeFunctionCall({
            name: "transfer",
            type: "function",
            inputs: [{
                    "name": "_to",
                    "type": "address"
                },
                {
                    "name": "_value",
                    "type": "uint256"
                }
            ],
        }, [
            _userAddress,
            caver_value
        ]);

        const sendToPerWallet = await caver.klay.sendTransaction({
            type: "SMART_CONTRACT_EXECUTION",
            account,
            to: token_address,
            data: sendToPerWallet_data,
            gas: 3000000,
        }).on("transactionHash", async(transactionHash) => {
            $("#cp_transaction").val(transactionHash);
        });
    });
});